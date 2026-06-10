<?php

namespace App\Filament\Resources\Ekstrakurikulers\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EkstrakurikulerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('nama')->required()->maxLength(120),
                TextInput::make('urutan')->numeric()->default(0),
                TextInput::make('jadwal')->placeholder('Senin 15.00–17.00'),
                TextInput::make('pembina'),
                SpatieMediaLibraryFileUpload::make('foto')->collection('foto')
                    ->image()->imageEditor()->columnSpanFull(),
                Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }
}
