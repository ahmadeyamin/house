<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a database backup, compresses it, uploads, and cleans up old backups.';

    // Configuration
    protected $diskName = 's3'; // As defined in config/filesystems.php
    protected $backupDir = 'backups'; // Directory within the R2 bucket
    protected $localTempPath = 'app/backup-temp'; // Local temporary storage path relative to storage_path()
    protected $keepDays = 30; // Number of days to keep backups
    protected $filenamePrefix = 'backup-'; // Prefix for backup filenames
    protected $dateFormat = 'Y-m-d_H.i.s'; // Date format for filenames

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting database backup process...');

        $localFullPath = storage_path($this->localTempPath);
        if (!File::isDirectory($localFullPath)) {
            File::makeDirectory($localFullPath, 0755, true);
        }

        $timestamp = Carbon::now()->format($this->dateFormat);
        $baseFilename = $this->filenamePrefix . $timestamp;
        $sqlFilename = $baseFilename . '.sql';
        $compressedFilename = $baseFilename . '.sql.gz';
        $localSqlPath = $localFullPath . '/' . $sqlFilename;
        $localCompressedPath = $localFullPath . '/' . $compressedFilename;
        $remotePath = $this->backupDir . '/' . $compressedFilename;

        try {
            // 1. Create Database Dump
            $this->info('Creating database dump...');
            $this->createDump($localSqlPath);
            $this->info("Dump created: {$localSqlPath}");

            // 2. Compress Dump
            $this->info('Compressing database dump...');
            $this->compressDump($localSqlPath, $localCompressedPath);
            $this->info("Dump compressed: {$localCompressedPath}");

            // 3. Upload to local
            $this->info("Uploading to local disk ('{$this->diskName}') path: {$remotePath}...");
            $this->uploadToR2($localCompressedPath, $remotePath);
            $this->info('Upload successful.');

            // 4. Clean up local files
            $this->info('Cleaning up local temporary files...');
            $this->cleanupLocal($localSqlPath, $localCompressedPath);
            $this->info('Local cleanup complete.');

            // 5. Clean up old backups on R2
            $this->info('Cleaning up old backups on R2...');
            $this->cleanupRemote();
            $this->info('Remote cleanup complete.');

            $this->info('Database backup process completed successfully.');
            Log::info('Database backup to R2 completed successfully.');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            Log::error("Database backup to R2 failed: " . $e->getMessage(), [
                'exception' => $e->getTraceAsString() // Log stack trace for debugging
            ]);
            $this->error("Backup failed: " . $e->getMessage());

            // Attempt to clean up local files even on failure
            $this->cleanupLocal($localSqlPath, $localCompressedPath);
            return Command::FAILURE;
        }
    }

    /**
     * Create the database dump using mysqldump, pg_dump, or sqlite3.
     */
    protected function createDump(string $dumpPath): void
    {
        $dbConnection = config('database.default');
        $dbConfig = config("database.connections.{$dbConnection}");

        $command = null;
        $envVars = [];

        switch ($dbConfig['driver']) {
            case 'mysql':
                $command = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
                    escapeshellarg($dbConfig['username']),
                    escapeshellarg($dbConfig['password']),
                    escapeshellarg($dbConfig['host']),
                    escapeshellarg($dbConfig['port'] ?? '3306'),
                    escapeshellarg($dbConfig['database']),
                    escapeshellarg($dumpPath)
                );
                // Consider using --single-transaction for InnoDB tables to avoid locking all tables
                // $command .= ' --single-transaction';
                break;

            case 'pgsql':
                $command = sprintf(
                    'pg_dump --username=%s --host=%s --port=%s %s > %s',
                    escapeshellarg($dbConfig['username']),
                    escapeshellarg($dbConfig['host']),
                    escapeshellarg($dbConfig['port'] ?? '5432'),
                    escapeshellarg($dbConfig['database']),
                    escapeshellarg($dumpPath)
                );
                $envVars['PGPASSWORD'] = $dbConfig['password']; // pg_dump uses PGPASSWORD env variable
                break;

            case 'sqlite':
                $databasePath = $dbConfig['database'];
                
                // Ensure the SQLite file exists
                if (!file_exists($databasePath)) {
                    throw new \Exception("SQLite database file not found at: {$databasePath}");
                }

                // sqlite3 /path/to/db.sqlite .dump > /path/to/backup.sql
                $command = sprintf(
                    'sqlite3 %s .dump > %s',
                    escapeshellarg($databasePath),
                    escapeshellarg($dumpPath)
                );
                break;

            default:
                throw new \Exception("Unsupported database driver: {$dbConfig['driver']}");
        }

        $process = Process::fromShellCommandline($command, null, $envVars, null, null); // Timeout null = no timeout
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Compress the SQL dump file using gzip.
     */
    protected function compressDump(string $sourcePath, string $destinationPath): void
    {
        $command = sprintf(
            'gzip < %s > %s',
            escapeshellarg($sourcePath),
            escapeshellarg($destinationPath)
        );

        $process = Process::fromShellCommandline($command, null, null, null, null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Upload the compressed file to the configured R2 disk.
     */
    protected function uploadToR2(string $localPath, string $remotePath): void
    {
        $stream = fopen($localPath, 'r+');
        if (!$stream) {
             throw new \Exception("Failed to open local file for reading: {$localPath}");
        }

        try {
            $result = Storage::disk($this->diskName)->put($remotePath, $stream);
            if (!$result) {
                throw new \Exception("Failed to upload file to R2. Path: {$remotePath}");
            }
        } finally {
             if (is_resource($stream)) {
                fclose($stream);
             }
        }

    }

    /**
     * Clean up local temporary files.
     */
    protected function cleanupLocal(?string $sqlPath, ?string $compressedPath): void
    {
        if ($sqlPath && File::exists($sqlPath)) {
            File::delete($sqlPath);
        }
        if ($compressedPath && File::exists($compressedPath)) {
            File::delete($compressedPath);
        }
    }

    /**
     * Delete backups older than $this->keepDays from the R2 disk.
     */
    protected function cleanupRemote(): void
    {
        $files = Storage::disk($this->diskName)->files($this->backupDir);
        $cutoffDate = Carbon::now()->subDays($this->keepDays);
        $deletedCount = 0;

        $this->info("Found " . count($files) . " files in {$this->backupDir}. Checking against cutoff date: " . $cutoffDate->toDateString());

        foreach ($files as $file) {
            // Extract timestamp from filename based on $filenamePrefix and $dateFormat
            $filename = basename($file);
            if (strpos($filename, $this->filenamePrefix) === 0) {
                $dateString = substr(
                    $filename,
                    strlen($this->filenamePrefix),
                    strlen(Carbon::now()->format($this->dateFormat)) // Length of the date part
                );

                try {
                    $fileDate = Carbon::createFromFormat($this->dateFormat, $dateString);
                    if ($fileDate->lt($cutoffDate)) {
                        $this->info("Deleting old backup: {$file}");
                        Storage::disk($this->diskName)->delete($file);
                        $deletedCount++;
                    }
                } catch (\InvalidArgumentException $e) {
                    $this->warn("Could not parse date from filename: {$filename}. Skipping cleanup for this file.");
                    Log::warning("Could not parse date from backup filename: {$filename}", ['file' => $file]);
                }
            }
        }

        $this->info("Deleted {$deletedCount} old backup files from R2.");
    }
}