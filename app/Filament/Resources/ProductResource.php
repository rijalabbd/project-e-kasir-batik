<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->required()
                ->label('Nama Produk'),

            TextInput::make('harga')
                ->numeric()
                ->required()
                ->label('Harga Produk'),

            TextInput::make('stok')
                ->numeric()
                ->required()
                ->label('Stok Produk'),

            // Menyimpan gambar ke direktori products/
            FileUpload::make('gambar')
                ->image()
                ->label('Upload Gambar')
                ->disk('public')
                ->directory('products')  // Gambar disimpan di storage/app/public/products/
                ->visibility('public')
                ->imagePreviewHeight('150'),

            TextInput::make('barcode')
                ->default(fn () => (string) rand(1_000_000_000, 9_999_999_999))
                ->unique()
                ->label('Barcode (angka saja)'), 

            Checkbox::make('is_preorder')
                ->label('Produk Preorder'),

            DatePicker::make('preorder_available_date')
                ->label('Tanggal Ketersediaan Preorder')
                ->nullable()
                ->visible(fn ($get) => $get('is_preorder')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Gambar Produk
                ImageColumn::make('gambar')
                    ->label('Gambar Produk')
                    ->disk('public')
                    ->width(80)
                    ->height(80)
                    ->circular(),

                // Nama, Harga, Stok
                TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->sortable(),

                TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),

                // Barcode Produk
                TextColumn::make('barcode_image')
                    ->label('Barcode')
                    ->formatStateUsing(fn ($state) => $state 
                        ? "<img src='" . asset('storage/' . $state) . "' width='100' height='50'>" 
                        : ''
                    )
                    ->html(),

                // Preorder
                IconColumn::make('is_preorder')
                    ->label('Preorder')
                    ->boolean(),

                TextColumn::make('preorder_available_date')
                    ->label('Tgl Preorder')
                    ->date('d-m-Y'),
            ])
            ->actions([
                EditAction::make(),

                // Action untuk download barcode
                Action::make('downloadBarcode')
                    ->label('Download Barcode')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->action(fn (Product $record) => response()->download(
                        storage_path("app/public/{$record->barcode_image}")
                    )),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
