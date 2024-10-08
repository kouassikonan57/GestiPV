<?php

namespace App\Filament\Resources\EcueResource\Pages;

use App\Filament\Resources\EcueResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEcues extends ManageRecords
{
    protected static string $resource = EcueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
