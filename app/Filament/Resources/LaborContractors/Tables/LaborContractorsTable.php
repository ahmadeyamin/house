<?php

namespace App\Filament\Resources\LaborContractors\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Models\Payment;

class LaborContractorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('role')
                    ->searchable(),
                TextColumn::make('payment_type')
                    ->searchable(),
                TextColumn::make('wage_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('advance_paid')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_paid')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('contact')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('project_id')
                    ->relationship('project', 'name'),
                SelectFilter::make('role')
                    ->options([
                        'mason' => 'Mason',
                        'electrician' => 'Electrician',
                        'plumber' => 'Plumber',
                        'carpenter' => 'Carpenter',
                        'painter' => 'Painter',
                        'other' => 'Other',
                    ]),
                SelectFilter::make('payment_type')
                    ->options([
                        'daily_wage' => 'Daily Wage',
                        'contract' => 'Contract-based',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('record_payment')
                    ->label('Record Payment')
                    ->icon('heroicon-o-currency-dollar')
                    ->form([
                        TextInput::make('amount')
                            ->label('Payment Amount')
                            ->required()
                            ->numeric(),
                        DatePicker::make('payment_date')
                            ->required(),
                    ])
                    ->action(function (Model $record, array $data): void {
                        Payment::create([
                            'project_id' => $record->project_id,
                            'payment_type' => 'labor',
                            'vendor_id' => null,
                            'amount' => $data['amount'],
                            'payment_date' => $data['payment_date'],
                            'status' => 'paid',
                            'notes' => 'Payment recorded through Labor Contractor action',
                        ]);
                        $record->total_paid += $data['amount'];
                        $record->save();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
