<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PanduanSistemWidget extends Widget
{
    protected static ?int $sort = 3;

    protected string $view = 'filament.widgets.panduan-sistem-widget';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        return [
            'tourCompleted' => $user?->system_tour_completed ?? false,
        ];
    }
}
