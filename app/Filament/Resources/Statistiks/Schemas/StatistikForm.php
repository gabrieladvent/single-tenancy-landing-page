<?php

namespace App\Filament\Resources\Statistiks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StatistikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required(),
                TextInput::make('angka')
                    ->required(),
                TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
