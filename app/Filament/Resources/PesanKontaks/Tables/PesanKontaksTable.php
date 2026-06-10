<?php

namespace App\Filament\Resources\PesanKontaks\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PesanKontaksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('dibaca')->label('')->boolean()
                    ->trueIcon('heroicon-o-envelope-open')->falseIcon('heroicon-s-envelope'),
                TextColumn::make('nama')->searchable()
                    ->weight(fn ($record) => $record->dibaca ? null : 'bold'),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('pesan')->limit(60)->wrap(),
                TextColumn::make('created_at')->label('Diterima')->dateTime('d M Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                Action::make('tandai')
                    ->label(fn ($record) => $record->dibaca ? 'Tandai belum' : 'Tandai dibaca')
                    ->icon('heroicon-o-check')
                    ->action(fn ($record) => $record->update(['dibaca' => ! $record->dibaca])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
