<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')

    <div class="container">
        <div class="card">
            <div class="page-header">
                <h1>Data Peminjaman</h1>

            <div class="button-group">
                <a href="{{ route('peminjaman.export.pdf') }}" class="btn btn-pdf">
                    Download PDF
                </a>

                <a href="{{ route('peminjaman.export.excel') }}" class="btn btn-excel">
                    Download Excel
                </a>

                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                    Tambah Peminjaman
                </a>
            </div>
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
                        <th class="col-no">No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th class="col-aksi-peminjaman">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->peminjam->nama_peminjam ?? '-' }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>{{ $item->jumlah_pinjam }}</td>
                            <td>
                                <span class="status-badge status-{{ $item->status_peminjaman }}">
                                    {{ ucfirst($item->status_peminjaman) }}
                                </span>
                            </td>
                            <td>
                                <div class="col-aksi-peminjaman">
                                    @if (in_array($item->status_peminjaman, ['dipinjam', 'terlambat']))
                                        <a href="{{ route('peminjaman.edit', $item) }}" class="btn btn-warning btn-small">
                                            Edit
                                        </a>

                                        <form action="{{ route('peminjaman.kembalikan', $item) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-success btn-small" onclick="return confirm('Yakin barang ini sudah dikembalikan?')">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('peminjaman.destroy', $item) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('Yakin hapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</body>
</html>
