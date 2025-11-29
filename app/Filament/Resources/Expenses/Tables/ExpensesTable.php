<?php

namespace App\Filament\Resources\Expenses\Tables;

use App\Models\Contract;
use App\Models\DailyReport;
use App\Models\Material;
use App\Models\Project;
use App\Models\Rent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
                    ->label('Category')
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('BDT')
                    ->label('Amount')
                    ->summarize(Sum::make()->money('BDT')),
                TextColumn::make('notes')
                    ->label('Note')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('expense_date')
                    ->date()
                    ->description(function (Model $record) {
                        return "at ".$record->created_at->format('M d, y | h:i A');
                    })
                    ->label('Date')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->defaultPaginationPageOption(50)
            ->filters([
                Filter::make('expense_date')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '<=', $date),
                            );
                    }),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                SelectFilter::make('expenseable_type')
                    ->label('Type')
                    ->options([
                        Material::class => 'Material',
                        Contract::class => 'Contract',
                        Rent::class => 'Rent',
                        DailyReport::class => 'Daily Report',
                    ]),
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
