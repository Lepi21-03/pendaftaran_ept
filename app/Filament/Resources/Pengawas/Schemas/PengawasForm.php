<?php

namespace App\Filament\Resources\Pengawas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class PengawasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal_ujian')
                    ->label('Tanggal Ujian')
                    ->required()
                    ->minDate(now()->startOfDay())
                    ->validationMessages([
                        'after_or_equal' => 'Tanggal ujian tidak boleh di masa lalu.',
                    ])
                    ->rule('after_or_equal:today')
                    ->unique(ignoreRecord: true),

                TextInput::make('kuota')
                    ->label('Kuota')
                    ->numeric()
                    ->default(40)
                    ->required(),

                TextInput::make('harga_ujian')
                    ->label('Harga Ujian (Rp)')
                    ->numeric()
                    ->default(100000)
                    ->minValue(1)
                    ->required()
                    ->prefix('Rp')
                    ->helperText('Harga ini akan digunakan sebagai nominal invoice Xendit saat peserta melakukan pembayaran.')
                    ->hint('⚡ Berlaku pada pendaftaran baru')
                    ->hintColor('warning'),

                TextInput::make('lokasi')
                    ->label('Lokasi Gedung/Ruangan')
                    ->placeholder('Contoh: Gedung A, Ruang 101')
                    ->required(),

                Select::make('pengawas')
                    ->label('Daftar Pengawas')
                    ->multiple()
                    ->relationship('pengawas', 'nama')
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
