<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private int $nomor = 0;

    public function collection(): Collection
    {
        return Peminjaman::with(['peminjam', 'barang'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Kelas',
            'Jurusan',
            'Nama Barang',
            'Kategori Barang',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Jumlah Pinjam',
            'Status Peminjaman',
        ];
    }

    public function map($peminjaman): array
    {
        $this->nomor++;

        return [
            $this->nomor,
            $peminjaman->peminjam->nama_peminjam ?? '-',
            $peminjaman->peminjam->kelas ?? '-',
            $peminjaman->peminjam->jurusan ?? '-',
            $peminjaman->barang->nama_barang ?? '-',
            $peminjaman->barang->kategori_barang ?? '-',
            date('d/m/Y H:i', strtotime($peminjaman->tanggal_pinjam)),
            $peminjaman->tanggal_kembali ? date('d/m/Y H:i', strtotime($peminjaman->tanggal_kembali)) : '-',
            $peminjaman->jumlah_pinjam,
            ucfirst($peminjaman->status_peminjaman),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = Peminjaman::count() + 1;

        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '4F86C6',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:J' . $lastRow)->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => 'C9DCEF',
                ],
            ],
        ]);

        $sheet->getStyle('A1:J' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('I2:I' . $lastRow)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getRowDimension(1)->setRowHeight(24);

        for ($row = 2; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(22);
        }

        return [];
    }
}
