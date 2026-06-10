<?php

namespace App\Filament\Resources\Galeris\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GaleriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('judul')->required()->maxLength(120),
                TextInput::make('kategori')->placeholder('Kegiatan, Lomba, Fasilitas, ...'),
                TextInput::make('urutan')->numeric()->default(0),
                SpatieMediaLibraryFileUpload::make('foto')->collection('foto')
                    ->image()->multiple()->reorderable()->appendFiles()
                    ->panelLayout('grid')->columnSpanFull()
                    ->helperText('Bisa unggah banyak foto sekaligus.'),
            ]),
        ]);
    }
}
