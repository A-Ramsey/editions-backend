<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Date;

class EditionsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::all()->count()),
            Stat::make('New Users', User::whereDate('created_at', Date::today())->get()->count()),
            Stat::make('Todays Editions', Post::onDate(Date::today())->count()),
            Stat::make('Yesterdays Editons', Post::onDate(Date::yesterday())->count()),
        ];
    }
}
