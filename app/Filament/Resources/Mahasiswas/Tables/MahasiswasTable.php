<?php

namespace App\Filament\Resources\Mahasiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class MahasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->avatar
                        ?: 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=6366f1&color=fff&size=64'
                    )
                    ->extraImgAttributes(['referrerpolicy' => 'no-referrer']),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Akun Google')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('prodi')
                    ->label('Prodi')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('daftars.status')
                    ->label('Status Pendaftaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                
                \Filament\Actions\Action::make('cetak_kartu')
                    ->label('Kartu')
                    ->icon('heroicon-o-identification')
                    ->color('info')
                    ->action(function ($record) {
                        // Ambil pendaftaran terakhir yang sukses
                        $daftar = $record->daftars()->where('status', 'success')->with('ujian')->latest()->first();
                        
                        if (!$daftar) {
                            \Filament\Notifications\Notification::make()
                                ->title('Pendaftaran tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }

                        return response()->streamDownload(function () use ($daftar) {
                            echo \Barryvdh\DomPDF\Facade\Pdf::loadView('mahasiswa.dokumen.kartu-ujian', ['record' => $daftar])
                                ->setPaper([0, 0, 420.94, 283.46], 'landscape') // 14.85cm x 10cm
                                ->output();
                        }, 'Kartu-Ujian-' . $daftar->nim . '.pdf');
                    }),

                \Filament\Actions\Action::make('cetak_sertifikat')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->action(function ($record) {
                        // Cek apakah nilai sudah ada
                        if (!$record->score) {
                            \Filament\Notifications\Notification::make()
                                ->title('Anda belum menambahkan nilai')
                                ->danger()
                                ->send();
                            return;
                        }

                        return response()->streamDownload(function () use ($record) {
                            echo \Barryvdh\DomPDF\Facade\Pdf::loadView('mahasiswa.dokumen.sertifikat', ['mahasiswa' => $record])
                                ->setPaper('a4', 'landscape')
                                ->output();
                        }, 'Sertifikat-' . $record->nim . '.pdf');
                    }),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
