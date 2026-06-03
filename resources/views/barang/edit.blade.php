<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')
    <div class="container">
        <div class="card">
            <div class="page-header">
                <h1>Edit Barang</h1>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('barang.update', $barang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}">
                </div>

                <div class="form-group">
                    <label>Kategori Barang</label>
                    <input type="text" name="kategori_barang" value="{{ old('kategori_barang', $barang->kategori_barang) }}">
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" min="0" value="{{ old('stok', $barang->stok) }}">
                </div>

                <div class="form-group">
                    <label>Kondisi Barang</label>
                    <select name="kondisi_barang">
                        <option value="Baik" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </form>
        </div>
    </div>
</body>
</html>
