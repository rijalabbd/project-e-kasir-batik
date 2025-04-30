<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'gambar',
        'barcode',
        'barcode_image',
        'is_preorder',
        'preorder_available_date',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            // 1) Generate angka barcode jika belum ada
            if (! $product->barcode) {
                $product->barcode = (string) rand(1_000_000_000, 9_999_999_999);
            }

            // 2) Buat data PNG barcode
            $generator = new BarcodeGeneratorPNG();
            $pngData   = $generator->getBarcode(
                $product->barcode,
                $generator::TYPE_CODE_128
            );

            // 3) Simpan ke storage/app/public/barcodes/
            $filename = "{$product->barcode}.png";
            Storage::disk('public')->put("barcodes/{$filename}", $pngData);

            // 4) Isi kolom dengan path relatif
            $product->barcode_image = "barcodes/{$filename}";
        });
    }
}
