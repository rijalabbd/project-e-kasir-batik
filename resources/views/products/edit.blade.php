<!-- resources/views/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $product->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $product->harga }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="{{ $product->stok }}" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>

        <div class="mb-3">
            <label for="is_preorder" class="form-label">Preorder</label>
            <select class="form-control" id="is_preorder" name="is_preorder">
                <option value="0" {{ $product->is_preorder == 0 ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ $product->is_preorder == 1 ? 'selected' : '' }}>Ya</option>
            </select>
        </div>

        <div class="mb-3" id="preorder_date_container">
            <label for="preorder_available_date" class="form-label">Tanggal Ketersediaan Preorder</label>
            <input type="date" class="form-control" id="preorder_available_date" name="preorder_available_date" value="{{ $product->preorder_available_date ? $product->preorder_available_date->format('Y-m-d') : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
</div>

<script>
    document.getElementById('is_preorder').addEventListener('change', function() {
        const preorderDateContainer = document.getElementById('preorder_date_container');
        if (this.value == '1') {
            preorderDateContainer.style.display = 'block';
        } else {
            preorderDateContainer.style.display = 'none';
        }
    });
</script>
@endsection
