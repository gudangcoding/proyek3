<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use App\Models\Satuan;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SatuanRelationManager extends RelationManager
{
    protected static string $relationship = 'Satuan';

    public function form(Form $form): Form
    {
        $userId = auth()->user()->id;
        return $form
            // ->columnspanfull(12)
            ->schema([
                Repeater::make('satuan')
                    ->schema([
                        Hidden::make('user_id')
                            ->default($userId),
                        TextInput::make('name')
                            ->columnSpan(3)
                            ->label('Nama Satuan'),
                        Select::make('parent_id')
                            ->options(Satuan::pluck('name', 'id'))
                            ->columnSpan(3)
                            ->label('Satuan Induk'),
                        TextInput::make('qty')
                            ->columnSpan(3)
                            ->numeric()
                            ->label('Qty'),
                        TextInput::make('price')
                            ->columnSpan(3)
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Harga'),
                    ])->columns(4),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_produk')
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
