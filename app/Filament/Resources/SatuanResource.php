<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatuanResource\Pages;
use App\Filament\Resources\SatuanResource\RelationManagers;
use App\Models\Satuan;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $userId = auth()->user()->id;
        return $form
            ->schema([

                Hidden::make('user_id')
                    ->default($userId),
                Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->searchable()
                    ->label('Produk'),
                TextInput::make('name')
                    ->placeholder('Ctn/Dz/Pact/Lusin dll')
                    ->label('Nama Satuan'),
                Select::make('parent_id')
                    ->label('Satuan Induk')
                    ->placeholder('Kosngkan Jika satuan Utama')
                    ->options(Satuan::whereNull('parent_id')->pluck('name', 'id')),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('produk_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSatuans::route('/'),
            'create' => Pages\CreateSatuan::route('/create'),
            'edit' => Pages\EditSatuan::route('/{record}/edit'),
        ];
    }
}
