<?php

namespace App\Filament\Resources\Prestasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PrestasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('lomba'),
                TextInput::make('tingkat'),
                TextInput::make('peringkat'),
                TextInput::make('tahun')
                    ->numeric(),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
