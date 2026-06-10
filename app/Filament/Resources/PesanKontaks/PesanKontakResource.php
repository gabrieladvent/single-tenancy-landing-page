<?php

namespace App\Filament\Resources\PesanKontaks;

use App\Filament\Resources\PesanKontaks\Pages\CreatePesanKontak;
use App\Filament\Resources\PesanKontaks\Pages\EditPesanKontak;
use App\Filament\Resources\PesanKontaks\Pages\ListPesanKontaks;
use App\Filament\Resources\PesanKontaks\Schemas\PesanKontakForm;
use App\Filament\Resources\PesanKontaks\Tables\PesanKontaksTable;
use App\Models\PesanKontak;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PesanKontakResource extends Resource
{
    protected static ?string $model = PesanKontak::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Pesan Masuk';

    protected static ?string $modelLabel = 'Pesan';

    protected static ?string $pluralModelLabel = 'Pesan Masuk';

    public static function getNavigationBadge(): ?string
    {
        return ((string) static::getModel()::where('dibaca', false)->count()) ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return PesanKontakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PesanKontaksTable::configure($table);
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
            'index' => ListPesanKontaks::route('/'),
            'create' => CreatePesanKontak::route('/create'),
            'edit' => EditPesanKontak::route('/{record}/edit'),
        ];
    }
}
