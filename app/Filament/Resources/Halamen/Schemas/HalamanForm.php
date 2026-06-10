<?php

namespace App\Filament\Resources\Halamen\Schemas;

use App\Models\Halaman;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class HalamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('judul')->required()->maxLength(180)->columnSpanFull(),
                TextInput::make('slug')
                    ->helperText('Kosongkan untuk otomatis. Slug halaman sistem tidak boleh diubah.')
                    ->maxLength(200)
                    ->disabled(fn (?Halaman $record) => $record?->tipe === 'sistem')
                    ->unique(ignoreRecord: true)
                    ->rule(fn (?Halaman $record) => $record?->tipe === 'sistem'
                        ? []
                        : [Rule::notIn(Halaman::SLUG_TERPESAN)]),
                Toggle::make('is_published')->label('Terbitkan')->default(true),
                RichEditor::make('konten')->columnSpanFull(),
                TextInput::make('urutan_menu')->numeric()->default(0),
            ]),
        ]);
    }
}
