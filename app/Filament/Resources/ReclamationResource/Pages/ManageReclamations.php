<?php

namespace App\Filament\Resources\ReclamationResource\Pages;

use App\Filament\Resources\ReclamationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReclamations extends ManageRecords
{
    protected static string $resource = ReclamationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
