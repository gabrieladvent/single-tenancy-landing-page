<?php

namespace App\Filament\Resources\Gurus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GurusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('foto')->collection('foto')->label('')->circular()->width(48)->height(48),
                TextColumn::make('nama')->searchable()->weight('medium'),
                TextColumn::make('jabatan')->searchable()->toggleable(),
                TextColumn::make('mapel')->label('Mapel')->searchable()->toggleable(),
                TextColumn::make('tipe')->badge()->formatStateUsing(fn ($state) => $state === 'tu' ? 'Tata Usaha' : 'Guru'),
                TextColumn::make('urutan')->numeric()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
