<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Statistik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')

    <div class="container">
        <div class="card">
            <div class="page-header">
                <div>
                    <h1>Dashboard Statistik</h1>
                    <p class="page-subtitle">
                        Ringkasan data inventaris dan peminjaman Lab TEFA.
                    </p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <p>Total Peminjam</p>
                    <h2>{{ $totalPeminjam }}</h2>
                </div>

                <div class="stat-card">
                    <p>Total Barang</p>
                    <h2>{{ $totalBarang }}</h2>
                </div>

                <div class="stat-card">
                    <p>Total Stok Barang</p>
                    <h2>{{ $totalStok }}</h2>
                </div>

                <div class="stat-card">
                    <p>Total Peminjaman</p>
                    <h2>{{ $totalPeminjaman }}</h2>
                </div>

                <div class="stat-card">
                    <p>Sedang Dipinjam</p>
                    <h2>{{ $sedangDipinjam }}</h2>
                </div>

                <div class="stat-card">
                    <p>Sudah Dikembalikan</p>
                    <h2>{{ $sudahDikembalikan }}</h2>
                </div>
            </div>

            <div class="dashboard-actions">
                <a href="{{ route('peminjam.index') }}" class="btn btn-secondary">
                    Lihat Peminjam
                </a>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    Lihat Barang
                </a>


                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                    Lihat Peminjaman
                </a>

                <a href="{{ route('barang.create') }}" class="btn btn-primary">
                    Tambah Barang
                </a>
                
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                    Tambah Peminjaman
                </a>
            </div>
        </div>

        <div class="card mt-20">
            <div class="page-header">
                <h1>Peminjaman Terbaru</h1>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerbaru as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->peminjam->nama_peminjam ?? '-' }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->jumlah_pinjam }}</td>
                            <td>
                                <span class="status-badge status-{{ $item->status_peminjaman }}">
                                    {{ ucfirst($item->status_peminjaman) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
