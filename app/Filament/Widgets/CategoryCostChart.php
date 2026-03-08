<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasCostDateRange;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class CategoryCostChart extends ChartWidget
{
    use HasCostDateRange;

    protected static ?int $sort = 5;

    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Cost by Category';

    protected bool $isCollapsible = true;

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = 'last30days';

    public function getDescription(): ?string
    {
        return 'Category-wise cost share (%) for ' . strtolower($this->getActiveCostFilterLabel($this->filter)) . '.';
    }

    protected function getFilters(): ?array
    {
        return $this->getCostDateFilters();
    }

    protected function getData(): array
    {
        [$start, $end] = $this->getCostDateRange($this->filter);

        $rows = Expense::query()
            ->selectRaw('categories.name as category_name, SUM(expenses.amount) as total_amount')
            ->join('categories', 'categories.id', '=', 'expenses.category_id')
            ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();

        $values = $rows->map(fn($row) => (float) $row->total_amount)->all();
        $grandTotal = array_sum($values);
        $labels = $rows->map(function ($row) use ($grandTotal) {
            $amount = (float) $row->total_amount;
            $percentage = $grandTotal > 0 ? ($amount / $grandTotal) * 100 : 0;
            $name = Str::limit($row->category_name, 18);

            return sprintf('%s (%.1f%%)', $name, $percentage);
        })->all();

        return [
            'datasets' => [
                [
                    'label' => 'Amount',
                    'data' => $values,
                    'backgroundColor' => $this->getPalette(count($values)),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'right',
                ],
            ],
        ];
    }

    protected function getPalette(int $count): array
    {
        $palette = [
            'rgba(14, 116, 144, 0.85)',
            'rgba(22, 163, 74, 0.85)',
            'rgba(202, 138, 4, 0.85)',
            'rgba(220, 38, 38, 0.85)',
            'rgba(124, 58, 237, 0.85)',
            'rgba(217, 70, 239, 0.85)',
            'rgba(2, 132, 199, 0.85)',
            'rgba(8, 145, 178, 0.85)',
            'rgba(180, 83, 9, 0.85)',
            'rgba(30, 64, 175, 0.85)',
        ];

        if ($count <= count($palette)) {
            return array_slice($palette, 0, $count);
        }

        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $colors[] = $palette[$i % count($palette)];
        }

        return $colors;
    }
}
