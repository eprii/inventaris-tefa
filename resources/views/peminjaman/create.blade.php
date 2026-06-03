<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')

    <div class="container">
        <div class="card">
            <div class="page-header">
                <h1>Tambah Peminjaman</h1>

                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Peminjam</label>
                    <select name="peminjam_id">
                        <option value="">Pilih peminjam</option>
                        @foreach ($peminjam as $item)
                            <option value="{{ $item->id }}" {{ old('peminjam_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_peminjam }} - {{ $item->kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Barang</label>
                    <select name="barang_id">
                        <option value="">Pilih barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_barang }} - Stok: {{ $item->stok }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="datetime-local" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="datetime-local" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
                </div>

                <div class="form-group">
                    <label>Jumlah Pinjam</label>
                    <input type="number" name="jumlah_pinjam" min="1" value="{{ old('jumlah_pinjam') }}">
                </div>

                <input type="hidden" name="status_peminjaman" value="dipinjam">

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</body>
</html>
