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

        $totalExpenses = Expense::sum('amount');

        return $totalExpenses / $project->estimated_budget * 100;
    }
}
