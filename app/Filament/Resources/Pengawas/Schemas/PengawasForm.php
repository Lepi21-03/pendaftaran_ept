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
                \Filament\Forms\Components\DatePicker::make('tanggal_ujian')
                    ->label('Tanggal Ujian')
                    ->required()
                    ->unique(ignoreRecord: true),
                \Filament\Forms\Components\TextInput::make('kuota')
                    ->label('Kuota')
                    ->numeric()
                    ->default(40)
                    ->required(),
                \Filament\Forms\Components\TextInput::make('lokasi')
                    ->label('Lokasi Gedung/Ruangan')
                    ->placeholder('Contoh: Gedung A, Ruang 101')
                    ->required(),
                \Filament\Forms\Components\Select::make('pengawas')
                    ->label('Daftar Pengawas')
                    ->multiple()
                    ->relationship('pengawas', 'nama')
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        \Filament\Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
