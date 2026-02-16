<?php

namespace App\Filament\Resources\Pengawas;

use App\Filament\Resources\Pengawas\Pages\CreatePengawas;
use App\Filament\Resources\Pengawas\Pages\EditPengawas;
use App\Filament\Resources\Pengawas\Pages\ListPengawas;
use App\Filament\Resources\Pengawas\Schemas\PengawasForm;
use App\Filament\Resources\Pengawas\Tables\PengawasTable;
use App\Models\Pengawas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengawasResource extends Resource
{
    protected static ?string $model = Pengawas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PengawasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengawasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengawas::route('/'),
            'create' => CreatePengawas::route('/create'),
            'edit' => EditPengawas::route('/{record}/edit'),
        ];
    }
}
