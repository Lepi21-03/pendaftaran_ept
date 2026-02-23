<?php

namespace App\Filament\Resources\Pengawas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PengawasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('tanggal_ujian')
                    ->label('Tanggal Ujian')
                    ->date()
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
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
