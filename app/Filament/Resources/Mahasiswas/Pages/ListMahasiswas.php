<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswas extends ListRecords
{
    protected static string $resource = MahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import_nilai')
                ->label('Import Nilai EPT dari Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->url(MahasiswaResource::getUrl('import-nilai')),

            CreateAction::make(),
        ];
    }
}
