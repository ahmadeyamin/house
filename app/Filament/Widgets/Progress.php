<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class Progress extends Widget
{
    protected string $view = 'filament.widgets.progress';


    protected int | string | array $columnSpan = 'full';


    protected function getProgress(): int
    {

        $project = Auth::user()->currentProject;

        $projectEstimatedBudget = $project->estimated_budget;
        $totalExpenses = Expense::sum('amount');

        return $projectEstimatedBudget > 0 ? ($totalExpenses / $projectEstimatedBudget) * 100 : 0;
    }
}
