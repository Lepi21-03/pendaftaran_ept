<?php

namespace App\Filament\Resources\Pengawas\Pages;

use App\Filament\Resources\Pengawas\PengawasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengawas extends ListRecords
{
    protected static string $resource = PengawasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
