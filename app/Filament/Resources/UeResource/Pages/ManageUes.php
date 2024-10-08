<?php

namespace App\Filament\Resources\UeResource\Pages;

use App\Filament\Resources\UeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUes extends ManageRecords
{
    protected static string $resource = UeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
