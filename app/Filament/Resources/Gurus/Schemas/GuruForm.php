<?php

namespace App\Filament\Resources\Gurus\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GuruForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                SpatieMediaLibraryFileUpload::make('foto')->collection('foto')
                    ->image()->imageEditor()->avatar()->columnSpanFull(),
                TextInput::make('nama')->required()->maxLength(120),
                Select::make('tipe')->options(['guru' => 'Guru', 'tu' => 'Tata Usaha'])
                    ->default('guru')->required(),
                TextInput::make('jabatan')->placeholder('Kepala Sekolah, Wali Kelas, ...'),
                TextInput::make('mapel')->label('Mata Pelajaran'),
                TextInput::make('urutan')->numeric()->default(0),
            ]),
        ]);
    }
}
