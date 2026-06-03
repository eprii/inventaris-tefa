<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #4f86c6;
            color: white;
            padding: 8px;
            border: 1px solid #ffffff;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #d1d5db;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>LAPORAN DATA PEMINJAMAN INVENTARIS TEFA</h2>
    <div class="subtitle">Sistem Inventaris dan Peminjaman Barang Lab TEFA</div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th class="text-center">Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->peminjam->nama_peminjam ?? '-' }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="text-center">{{ $item->jumlah_pinjam }}</td>
                    <td>{{ ucfirst($item->status_peminjaman) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
