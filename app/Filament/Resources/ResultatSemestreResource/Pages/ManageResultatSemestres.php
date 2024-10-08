<?php

namespace App\Filament\Resources\ResultatSemestreResource\Pages;

use App\Filament\Resources\ResultatSemestreResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageResultatSemestres extends ManageRecords
{
    protected static string $resource = ResultatSemestreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
