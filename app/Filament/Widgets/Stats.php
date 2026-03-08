<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\DailyReport;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends StatsOverviewWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $project = Auth::user()->currentProject;

        $today = now()->toDateString();
        $last7Start = now()->subDays(6)->toDateString();
        $last30Start = now()->subDays(29)->toDateString();

        $dailyReports = DailyReport::where('project_id', $project->id)->where('date', $today)->get();


        return [
            Stat::make('Project Budget', Number::currency($project->estimated_budget ?? 0))
                ->description('Total project maximum budget')
                ->icon(Heroicon::CurrencyDollar),

            Stat::make('Total Expenses', Number::currency(Expense::sum('amount') ?? 0))
                ->description('Total expenses')
                ->icon(Heroicon::DocumentCurrencyDollar),
            Stat::make('Today Expenses', function () use ($today) {
                return Number::currency(Expense::where('expense_date', $today)->sum('amount') ?? 0);
            })
                ->description('Today expenses')
                ->icon(Heroicon::CalendarDays),
            Stat::make('Last 7 Days Cost', function () use ($last7Start, $today) {
                return Number::currency(Expense::whereBetween('expense_date', [$last7Start, $today])->sum('amount') ?? 0);
            })
                ->description('Total cost in the last 7 days')
                ->icon(Heroicon::Calendar),
            Stat::make('Last 30 Days Cost', function () use ($last30Start, $today) {
                return Number::currency(Expense::whereBetween('expense_date', [$last30Start, $today])->sum('amount') ?? 0);
            })
                ->description('Total cost in the last 30 days')
                ->icon(Heroicon::Calendar),
            Stat::make('Total Workers', function () use ($dailyReports) {
                return $dailyReports ? $dailyReports->flatMap->dailyWorkers->sum('worker_count') : 0;
            })
                ->description('Total workers')
                ->icon(Heroicon::UserGroup),
        ];
    }
}
