<?php

namespace App\Filament\Resources\Statistiks;

use App\Filament\Resources\Statistiks\Pages\CreateStatistik;
use App\Filament\Resources\Statistiks\Pages\EditStatistik;
use App\Filament\Resources\Statistiks\Pages\ListStatistiks;
use App\Filament\Resources\Statistiks\Schemas\StatistikForm;
use App\Filament\Resources\Statistiks\Tables\StatistiksTable;
use App\Models\Statistik;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StatistikResource extends Resource
{
    protected static ?string $model = Statistik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Sekolah';

    protected static ?string $navigationLabel = 'Statistik';

    protected static ?string $modelLabel = 'Statistik';

    protected static ?string $pluralModelLabel = 'Statistik';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return StatistikForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatistiksTable::configure($table);
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
            'index' => ListStatistiks::route('/'),
            'create' => CreateStatistik::route('/create'),
            'edit' => EditStatistik::route('/{record}/edit'),
        ];
    }
}
