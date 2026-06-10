<?php

namespace App\Filament\Resources\Fasilitas\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FasilitasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('nama')->required()->maxLength(120),
                TextInput::make('urutan')->numeric()->default(0),
                SpatieMediaLibraryFileUpload::make('foto')->collection('foto')
                    ->image()->imageEditor()->columnSpanFull(),
                Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }
}
