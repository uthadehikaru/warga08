<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SequenceResource\Pages;
use App\Filament\Resources\SequenceResource\RelationManagers;
use App\Models\Sequence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SequenceResource extends Resource
{
    protected static ?string $model = Sequence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('sequence_date')
                    ->required(),
                Forms\Components\TextInput::make('rt')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('next_sequence')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sequence_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_sequence')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSequences::route('/'),
            'create' => Pages\CreateSequence::route('/create'),
            'edit' => Pages\EditSequence::route('/{record}/edit'),
        ];
    }
}
