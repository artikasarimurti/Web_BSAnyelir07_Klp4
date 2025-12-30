<?php

namespace App\Exports;

use App\Models\TransaksiSampah;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    protected $bulan;
    protected $tahun;
    protected $no = 1;
    protected $totalMasuk = 0;
    protected $totalKeluar = 0;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // 🔹 Data transaksi
    public function collection()
    {
        return TransaksiSampah::with(['nasabah', 'jenis'])
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->orderBy('tanggal')
            ->get();
    }

    // 🔹 Header tabel
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nomor Induk',
            'Nama Nasabah',
            'Jenis Sampah',
            'Kg',
            'Uang Masuk',
            'Uang Keluar',
        ];
    }

    // 🔹 Mapping data
    public function map($row): array
    {
        $this->totalMasuk  += $row->uang_masuk ?? 0;
        $this->totalKeluar += $row->uang_keluar ?? 0;

        return [
            $this->no++,
            Carbon::parse($row->tanggal)->format('d-m-Y'),
            $row->nasabah->nomor_induk ?? '-',
            $row->nasabah->nama ?? '-',
            $row->jenis->nama_jenis ?? '-',
            $row->kg ?? 0,
            $row->uang_masuk ?? 0,
            $row->uang_keluar ?? 0,
        ];
    }

    // 🔹 Tabel mulai baris ke-4
    public function startCell(): string
    {
        return 'A4';
    }

    // 🔹 Judul, Periode, dan TOTAL
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // ===== JUDUL =====
                $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI BULANAN');
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                // ===== PERIODE =====
                $awal  = Carbon::create($this->tahun, $this->bulan, 1)->format('d-m-Y');
                $akhir = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth()->format('d-m-Y');

                $sheet->setCellValue('A2', "Periode : $awal s/d $akhir");
                $sheet->mergeCells('A2:H2');

                // ===== TOTAL =====
                $lastRow = $sheet->getHighestRow() + 1;

                $sheet->setCellValue("A{$lastRow}", 'TOTAL');
                $sheet->mergeCells("A{$lastRow}:E{$lastRow}");
                $sheet->setCellValue("G{$lastRow}", $this->totalMasuk);
                $sheet->setCellValue("H{$lastRow}", $this->totalKeluar);

                $sheet->getStyle("A{$lastRow}:H{$lastRow}")
                      ->getFont()->setBold(true);
            }
        ];
    }
}
