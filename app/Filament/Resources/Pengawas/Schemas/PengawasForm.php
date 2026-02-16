<?php

namespace App\Filament\Resources\Pengawas\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;

class PengawasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
