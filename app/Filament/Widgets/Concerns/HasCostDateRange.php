<?php

namespace App\Filament\Widgets\Concerns;

use App\Models\Expense;
use Illuminate\Support\Carbon;

trait HasCostDateRange
{
    protected function getCostDateFilters(): array
    {
        return [
            'last7days' => 'Last 7 days',
            'last30days' => 'Last 30 days',
            'today' => 'Today',
            'this_month' => 'This month',
            'this_year' => 'This year',
            'all_time' => 'All time',
        ];
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    protected function getCostDateRange(?string $filter): array
    {
        $allTimeStart = Expense::query()->min('expense_date');

        return match ($filter) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'last7days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            'last30days' => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
            'this_year' => [now()->startOfYear(), now()->endOfYear()],
            'all_time' => [($allTimeStart ? Carbon::parse($allTimeStart) : now())->startOfDay(), now()->endOfDay()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }

    protected function getActiveCostFilterLabel(?string $filter): string
    {
        $filters = $this->getCostDateFilters();

        return $filters[$filter ?? 'last30days'] ?? $filters['last30days'];
    }
}
