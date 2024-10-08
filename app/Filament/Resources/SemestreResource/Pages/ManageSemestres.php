<?php

namespace App\Filament\Resources\SemestreResource\Pages;

use App\Filament\Resources\SemestreResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSemestres extends ManageRecords
{
    protected static string $resource = SemestreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
