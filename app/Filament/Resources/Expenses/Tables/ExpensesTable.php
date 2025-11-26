<?php

namespace App\Filament\Resources\Expenses\Tables;

use App\Models\Contract;
use App\Models\DailyReport;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\Rent;
use Filament\Actions\DeleteAction;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('expenseable_reference')
                    ->label('Reference')
                    ->getStateUsing(function (Model $record) {
                        // Get the related model
                        $target = $record->expenseable;

                        // Check if relationship exists
                        if (! $target) {
                            return null;
                        }

                        // Return specific field based on Model Class
                        return match (get_class($target)) {
                            Material::class => $target->name,        // Assumes Material has 'name'
                            Contract::class => $target->name,       // Assumes Contract has 'title'
                            Rent::class => '' . $target->name, // Assumes Rent has 'month'
                            DailyReport::class => "Report" . $target->date,     // Assumes DailyReport has 'date'
                            default => '#' . $target->id,
                        };
                    })
                    ->description(fn(Model $record) => 'ID: ' . $record->expenseable_id), // Optional: Show ID below name
                TextColumn::make('category.name')
                    ->label('Category'),
                TextColumn::make('amount')
                    ->money('BDT')
                    ->label('Amount'),
                TextColumn::make('notes')
                    ->label('Note')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d | h:i A')
                    ->label('Date'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
