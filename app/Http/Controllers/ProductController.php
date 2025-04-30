<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        // Ambil semua produk, termasuk yang preorder
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk menambahkan produk baru
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image', // Validasi gambar
            'is_preorder' => 'nullable|boolean', // Validasi preorder (optional)
            'preorder_available_date' => 'nullable|date|after:today', // Validasi tanggal preorder
        ]);

        // Jika ada gambar, simpan gambar produk
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        // Buat produk baru
        $product = new Product($validated);

        // Jika produk adalah preorder, tentukan tanggal ketersediaan preorder
        if ($product->is_preorder && !$product->preorder_available_date) {
            // Tentukan tanggal ketersediaan preorder (misalnya, 2 minggu ke depan)
            $product->preorder_available_date = now()->addWeeks(2); 
        }

        $product->save(); // Simpan produk ke database

        // Periksa apakah pengguna memilih untuk membuat produk lain
        if ($request->has('create_another')) {
            return redirect()->route('products.create')->with('success', 'Produk berhasil dibuat. Silakan buat produk lain.');
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image',
            'is_preorder' => 'nullable|boolean', // Optional
            'preorder_available_date' => 'nullable|date|after:today', // Optional
        ]);

        // Jika ada gambar, simpan gambar produk
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        // Perbarui produk
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        $product->delete(); // Hapus produk dari database
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
