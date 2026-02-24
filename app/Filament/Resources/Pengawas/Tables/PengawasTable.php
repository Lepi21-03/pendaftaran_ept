<?php

namespace App\Filament\Resources\Pengawas\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;

class PengawasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('tanggal_ujian')
                    ->label('Tanggal Ujian')
                    ->date('d M Y')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('kuota')
                    ->label('Kuota')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('daftars_count')
                    ->label('Terisi')
                    ->counts('daftars'),
                \Filament\Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('pengawas.nama')
                    ->label('Pengawas')
                    ->badge()
                    ->separator(','),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tombol Lihat Peserta (tampil modal langsung)
                Action::make('lihat_peserta')
                    ->label('Lihat Peserta')
                    ->icon('heroicon-o-users')
                    ->color('info')
                    ->modalHeading(fn ($record) =>
                        '📋 Peserta Ujian — ' . Carbon::parse($record->tanggal_ujian)->translatedFormat('d F Y')
                    )
                    ->modalWidth('4xl')
                    ->modalContent(fn ($record) => view(
                        'filament.modals.peserta-ujian',
                        [
                            'ujian'   => $record,
                            'daftars' => $record->daftars()->with('pembayaran')->get(),
                        ]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
