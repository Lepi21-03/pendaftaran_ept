<?php

namespace App\Filament\Resources\MasterPengawas\Pages;

use App\Filament\Resources\MasterPengawas\MasterPengawasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMasterPengawas extends ManageRecords
{
    protected static string $resource = MasterPengawasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
