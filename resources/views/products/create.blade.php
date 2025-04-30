<!-- resources/views/products/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Produk -->
        <div class="form-group">
            <label for="nama">Nama Produk*</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Harga Produk -->
        <div class="form-group">
            <label for="harga">Harga Produk*</label>
            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" required>
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stok Produk -->
        <div class="form-group">
            <label for="stok">Stok Produk*</label>
            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') }}" required>
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Upload Gambar -->
        <div class="form-group">
            <label for="gambar">Upload Gambar</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar">
        </div>

        <!-- Barcode Produk -->
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode', rand(1000000000, 9999999999)) }}" readonly>
        </div>

        <!-- Preorder Option -->
        <div class="form-group">
            <label for="is_preorder">Apakah Preorder?</label>
            <input type="checkbox" name="is_preorder" id="is_preorder" value="1" {{ old('is_preorder') ? 'checked' : '' }}>
        </div>

        <!-- Tanggal Ketersediaan Preorder -->
        <div class="form-group">
            <label for="preorder_available_date">Tanggal Ketersediaan Preorder</label>
            <input type="date" class="form-control" name="preorder_available_date" id="preorder_available_date" value="{{ old('preorder_available_date') }}">
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Create</button>
        <button type="submit" class="btn btn-secondary" name="create_another" value="1">Create & create another</button>
        <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
    </form>
</div>
@endsection
