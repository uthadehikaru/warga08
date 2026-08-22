<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JumantikResource\Pages;
use App\Models\Jumantik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JumantikResource extends Resource
{
    protected static ?string $model = Jumantik::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationLabel = 'Laporan Mandiri Jumantik';

    protected static ?string $modelLabel = 'Laporan Mandiri Jumantik';

    protected static ?string $pluralModelLabel = 'Laporan Mandiri Jumantik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->required()
                    ->rows(3),
                Forms\Components\Radio::make('has_jentik')
                    ->label('Apakah ditemukan jentik?')
                    ->boolean('Ya', 'Tidak')
                    ->inline()
                    ->required(),
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('jumantik')
                    ->disk('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rt')
                    ->label('RT')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\IconColumn::make('has_jentik')
                    ->label('Jentik')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListJumantiks::route('/'),
            'create' => Pages\CreateJumantik::route('/create'),
            'view' => Pages\ViewJumantik::route('/{record}'),
            'edit' => Pages\EditJumantik::route('/{record}/edit'),
        ];
    }
}
