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

        $dailyReports = DailyReport::where('project_id', $project->id)->where('date', $today)->first();


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
            Stat::make('Total Workers', function () use ($dailyReports) {
                return $dailyReports ? $dailyReports->dailyWorkers->sum('worker_count') : 0;
            })
                ->description('Total workers')
                ->icon(Heroicon::UserGroup),
        ];
    }
}
