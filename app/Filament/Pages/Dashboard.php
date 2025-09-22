<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return Heroicon::Home;
    }

}
