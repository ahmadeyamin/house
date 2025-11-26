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
                    ->url(function (Model $record) {
                        $target = $record->expenseable;
                        if (! $target) {
                            return null;
                        }

                        return match (get_class($target)) {
                            Material::class => route('filament.admin.resources.materials.view', $target),
                            Contract::class => route('filament.admin.resources.contracts.view', $target),
                            Rent::class => route('filament.admin.resources.rents.view', $target),
                            DailyReport::class => route('filament.admin.resources.daily-reports.view', $target),
                            default => null,
                        };
                    })
                    ->description(fn(Model $record) =>  class_basename($record->expenseable_type)), // Optional: Show ID below name
                TextColumn::make('category.name')
                    ->label('Category'),
                TextColumn::make('amount')
                    ->money('BDT')
                    ->label('Amount'),
                TextColumn::make('notes')
                    ->label('Note')
                    ->placeholder('-'),
                TextColumn::make('expense_date')
                    ->date()
                    ->description(function (Model $record) {
                        return "at ".$record->created_at->format('M d, y | h:i A');
                    })
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
