<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Filament\Resources\ProdukResource\RelationManagers\SatuanRelationManager;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $userId = auth()->user()->id;
        return $form
            ->schema([

                Hidden::make('user_id')
                    ->default($userId),
                Select::make('kategori_id')
                    ->relationship('kategori', 'name')
                    ->searchable()
                    ->createOptionForm(fn (Form $form) => KategoriResource::form($form))
                    ->editOptionForm(fn (Form $form) => KategoriResource::form($form))
                    ->label('Kategori'),
                FileUpload::make('gambar')
                    ->directory('produk')
                    ->label('Gambar Produk'),
                TextInput::make('kode_produk')
                    ->default('P-' . $userId . str_pad(Produk::max('id') + 1, 4, '0', STR_PAD_LEFT))
                    ->label('Kode Produk'),
                TextInput::make('nama_produk_cn')
                    ->maxLength(255),
                TextInput::make('nama_produk')
                    ->required()
                    ->maxLength(255),
                Toggle::make('aktif')
                    ->default(true)
                    ->label('Aktifkan Produk'),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),

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
                Tables\Columns\TextColumn::make('kategori_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gambar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_produk_cn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_produk')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
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
            SatuanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
