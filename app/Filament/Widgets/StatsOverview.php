<?php

namespace App\Filament\Widgets;

use App\Models\Etudiant;
use App\Models\ProcesVerbal;
use App\Models\Ue;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Étudiants', Etudiant::count())
                ->description('Nombre total d\'étudiants inscrits'),

            Card::make('Total UE', Ue::count())
                ->description('Nombre total d\'unités d\'enseignement'),

            Card::make('Moyenne Générale', number_format(ProcesVerbal::query()->avg('moyenne'), 2))
                ->description('Moyenne générale des étudiants')
                ->descriptionIcon('heroicon-o-arrow-trending-up'),


            Card::make('Nombre d\'AJOURNE', ProcesVerbal::where('decision', 'AJOURNE')->count())
                ->description('Étudiants ayant échoué')
                ->color('danger'),
        ];
    }
}
