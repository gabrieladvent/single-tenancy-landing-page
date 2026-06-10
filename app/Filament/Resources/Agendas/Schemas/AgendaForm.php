<?php

namespace App\Filament\Resources\Agendas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AgendaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->required(),
                DateTimePicker::make('mulai')
                    ->required(),
                DateTimePicker::make('selesai'),
                TextInput::make('lokasi'),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
