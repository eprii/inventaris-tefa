<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar.navbar')

    <div class="container">
        <div class="card">
            <div class="page-header">
                <div>
                    <h1>Data Peminjam</h1>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No HP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjam as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_peminjam }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->jurusan }}</td>
                            <td>{{ $item->no_hp ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada data peminjam.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $peminjam->links() }}
            </div>
        </div>
    </div>
</body>
</html>
