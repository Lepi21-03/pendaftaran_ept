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
                    ->minDate(now()->startOfDay())
                    ->validationMessages([
                        'after_or_equal' => 'Tanggal ujian tidak boleh di masa lalu.',
                    ])
                    ->rule('after_or_equal:today')
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
