<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasCostDateRange;
use App\Models\Contract;
use App\Models\DailyReport;
use App\Models\Expense;
use App\Models\Material;
use App\Models\Rent;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class CostTypeChart extends ChartWidget
{
    use HasCostDateRange;

    protected static ?int $sort = 6;

    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Cost by Type';

    protected bool $isCollapsible = true;

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = 'last30days';

    public function getDescription(): ?string
    {
        return 'Expense source totals with contract-wise breakdown for ' . strtolower($this->getActiveCostFilterLabel($this->filter)) . '.';
    }

    protected function getFilters(): ?array
    {
        return $this->getCostDateFilters();
    }

    protected function getData(): array
    {
        [$start, $end] = $this->getCostDateRange($this->filter);

        $nonContractRows = Expense::query()
            ->selectRaw('expenseable_type, SUM(amount) as total_amount')
            ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->where('expenseable_type', '!=', Contract::class)
            ->groupBy('expenseable_type')
            ->orderByDesc('total_amount')
            ->get()
            ->map(fn($row) => [
                'label' => $this->resolveTypeLabel($row->expenseable_type),
                'total_amount' => (float) $row->total_amount,
            ]);

        $contractRows = Expense::query()
            ->join('contracts', 'contracts.id', '=', 'expenses.expenseable_id')
            ->selectRaw('contracts.name as contract_name, SUM(expenses.amount) as total_amount')
            ->where('expenses.expenseable_type', Contract::class)
            ->whereBetween('expenses.expense_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('contracts.id', 'contracts.name')
            ->orderByDesc('total_amount')
            ->get()
            ->map(fn($row) => [
                'label' => 'Contract: ' . Str::limit($row->contract_name, 24),
                'total_amount' => (float) $row->total_amount,
            ]);

        $rows = $contractRows
            ->concat($nonContractRows)
            ->sortByDesc('total_amount')
            ->values();

        return [
            'datasets' => [
                [
                    'label' => 'Amount',
                    'data' => $rows->pluck('total_amount')->all(),
                    'backgroundColor' => 'rgba(2, 132, 199, 0.3)',
                    'borderColor' => '#0284c7',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $rows->pluck('label')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function resolveTypeLabel(string $type): string
    {
        return match ($type) {
            Material::class => 'Material',
            Contract::class => 'Contract',
            Rent::class => 'Rent',
            DailyReport::class => 'Daily Report',
            default => class_basename($type),
        };
    }
}
