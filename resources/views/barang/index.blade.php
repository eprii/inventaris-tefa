<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')
    <div class="container">
        <div class="card">
            <div class="page-header">
                <h1>Data Barang</h1>

                <a href="{{ route('barang.create') }}" class="btn btn-primary">
                    Tambah Barang
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori_barang }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>{{ $item->kondisi_barang }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $item) }}" class="btn btn-warning btn-small">
                                    Edit
                                </a>

                                <form action="{{ route('barang.destroy', $item) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('Yakin hapus barang ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
</body>
</html>
