<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('npm')
                    ->label('NPM')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                TextInput::make('prodi')
                    ->label('Program Studi')
                    ->required()
                    ->maxLength(255),
                TextInput::make('score')
                    ->label('Nilai EPT')
                    ->numeric()
                    ->maxValue(677) // TOEFL range usually up to 677
                    ->minValue(310),
            ]);
    }
}
