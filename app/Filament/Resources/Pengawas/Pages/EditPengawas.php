<?php

namespace App\Filament\Resources\Pengawas\Pages;

use App\Filament\Resources\Pengawas\PengawasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengawas extends EditRecord
{
    protected static string $resource = PengawasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
