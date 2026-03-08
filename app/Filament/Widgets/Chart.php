<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasCostDateRange;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class Chart extends ChartWidget
{
    use HasCostDateRange;

    protected static ?int $sort = 4;

    protected static ?string $minHeight = '350px';

    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Total Cost Trend';

    protected bool $isCollapsible = true;

    public ?string $filter = 'last30days';

    public function getDescription(): ?string
    {
        return 'Daily total cost for ' . strtolower($this->getActiveCostFilterLabel($this->filter)) . '.';
    }

    protected int|string|array $columnSpan = 'full';


    protected function getFilters(): ?array
    {
        return $this->getCostDateFilters();
    }

    protected function getData(): array
    {
        [$start, $end] = $this->getCostDateRange($this->filter);

        $trendData = Trend::model(Expense::class)
            ->between(
                start: $start,
                end: $end,
            )
            ->dateColumn('expense_date')
            ->perDay()
            ->sum('amount');

        $totalCost = $trendData->sum(fn(TrendValue $value) => (float) $value->aggregate);

        return [
            'datasets' => [
                [
                    'label' => 'Total cost (' . number_format($totalCost, 2) . ' BDT)',
                    'data' => $trendData->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#0f766e',
                    'backgroundColor' => 'rgba(15, 118, 110, 0.16)',
                    'fill' => true,
                ],
            ],
            'labels' => $trendData->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M d, y')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'elements' => [
                'line' => [
                    'tension' => 0.35,
                ],
                'point' => [
                    'radius' => 3,
                    'hoverRadius' => 5,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
