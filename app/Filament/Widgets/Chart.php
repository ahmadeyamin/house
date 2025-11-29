<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class Chart extends ChartWidget
{

    protected static ?int $sort = 4;

    protected static ?string $minHeight = '350px';

    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Expenses Chart';

    protected bool $isCollapsible = true;

    public function getDescription(): ?string
    {
        return 'Expenses chart for the selected filter';
    }

    protected int|string|array $columnSpan = 'full';


    protected function getFilters(): ?array
    {
        return [
            'month' => 'Last month',
            'today' => 'Today',
            'week' => 'Last week',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {

        $activeFilter = $this->filter;

        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        if ($activeFilter === 'week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        } elseif ($activeFilter === 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } elseif ($activeFilter === 'year') {
            $start = now()->startOfYear();
            $end = now()->endOfYear();
        } elseif ($activeFilter === 'today') {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        }


        $data = Trend::model(Expense::class)
            ->between(
                start: $start,
                end: $end,
            )
            ->dateColumn('expense_date')
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Amount',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M d, y')),
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
                    'tension' => 0.4,
                ],
                'point' => [
                    'borderRadius' => 5,
                ],
            ],
        ];
    }
}
