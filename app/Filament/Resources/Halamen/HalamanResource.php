<?php

namespace App\Filament\Resources\Halamen;

use App\Filament\Resources\Halamen\Pages\CreateHalaman;
use App\Filament\Resources\Halamen\Pages\EditHalaman;
use App\Filament\Resources\Halamen\Pages\ListHalamen;
use App\Filament\Resources\Halamen\Schemas\HalamanForm;
use App\Filament\Resources\Halamen\Tables\HalamenTable;
use App\Models\Halaman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HalamanResource extends Resource
{
    protected static ?string $model = Halaman::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Halaman';

    protected static ?string $modelLabel = 'Halaman';

    protected static ?string $pluralModelLabel = 'Halaman';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return HalamanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HalamenTable::configure($table);
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
            'index' => ListHalamen::route('/'),
            'create' => CreateHalaman::route('/create'),
            'edit' => EditHalaman::route('/{record}/edit'),
        ];
    }
}
