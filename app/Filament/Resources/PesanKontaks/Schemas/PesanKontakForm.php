<?php

namespace App\Filament\Resources\PesanKontaks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PesanKontakForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pesan dari Pengunjung')->columns(2)->schema([
                TextInput::make('nama')->disabled(),
                TextInput::make('email')->disabled(),
                Textarea::make('pesan')->disabled()->rows(5)->columnSpanFull(),
                Toggle::make('dibaca')->label('Sudah dibaca')->inline(false),
            ]),
        ]);
    }
}
