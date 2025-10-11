<?php

use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daily_workers', function (Blueprint $table) {
            $table->foreignIdFor(Contract::class)->nullable()->constrained('contracts')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // Skip rollback for SQLite because altering tables is limited
            return;
        }

        Schema::table('daily_workers', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropColumn('contract_id');
        });
    }
};
