<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konten')->columns(2)->schema([
                TextInput::make('judul')->required()->maxLength(180)->columnSpanFull(),
                TextInput::make('slug')->helperText('Kosongkan untuk dibuat otomatis dari judul.')
                    ->unique(ignoreRecord: true)->maxLength(200),
                DatePicker::make('tanggal')->required()->default(now())->native(false),
                TextInput::make('kategori')->placeholder('Pengumuman, Prestasi, ...'),
                SpatieMediaLibraryFileUpload::make('cover')->collection('cover')
                    ->image()->imageEditor()->columnSpanFull(),
                Textarea::make('ringkasan')->rows(2)->maxLength(300)->columnSpanFull()
                    ->helperText('Ringkasan singkat untuk kartu & meta description.'),
                RichEditor::make('isi')->columnSpanFull(),
            ]),
            Section::make('Publikasi')->schema([
                Toggle::make('is_published')->label('Terbitkan')->default(true),
            ]),
        ]);
    }
}
