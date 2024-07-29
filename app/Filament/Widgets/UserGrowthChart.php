<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\User;

class UserGrowthChart extends ChartWidget
{
    protected static ?string $heading = 'Total Users';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        $curTotalUsers = User::whereDate('created_at', '<', now()->subMonth())->get()->count();
        $userGrowth = collect();
        $cumulativeUsers = 0;
        foreach ($data as $date => $value) {
            $curTotalUsers += $value->aggregate;
            $userGrowth->push($curTotalUsers);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $userGrowth,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
