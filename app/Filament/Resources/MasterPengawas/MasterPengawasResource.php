<?php

namespace App\Filament\Resources\MasterPengawas;

use App\Filament\Resources\MasterPengawas\Pages\ManageMasterPengawas;
use App\Models\Pengawas;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterPengawasResource extends Resource
{
    protected static ?string $model = Pengawas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

    protected static ?string $navigationLabel = 'Data Pengawas';

    protected static ?string $modelLabel = 'Pengawas';

    protected static ?string $pluralModelLabel = 'Data Pengawas';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Informasi Pengawas')
                    ->description('Masukkan nama lengkap pengawas yang akan bertugas.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama pengawas...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Pengawas')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Nama disalin')
                    ->icon('heroicon-m-user'),
                TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMasterPengawas::route('/'),
        ];
    }
}
