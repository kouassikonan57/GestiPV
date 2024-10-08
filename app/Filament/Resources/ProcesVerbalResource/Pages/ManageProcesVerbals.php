<?php

namespace App\Filament\Resources\ProcesVerbalResource\Pages;

use App\Filament\Resources\ProcesVerbalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcesVerbals extends ManageRecords
{
    protected static string $resource = ProcesVerbalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
