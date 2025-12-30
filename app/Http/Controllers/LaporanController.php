<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSampah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $laporan = TransaksiSampah::with('jenis')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jenis_transaksi', 'setoran')
            ->selectRaw('jenis_id, SUM(kg) as total_kg, SUM(uang_masuk) as total_uang')
            ->groupBy('jenis_id')
            ->get();

        $total = TransaksiSampah::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('jenis_transaksi', 'setoran')
            ->selectRaw('SUM(kg) as total_kg, SUM(uang_masuk) as total_uang')
            ->first();

        return view('laporan.index', compact(
            'laporan',
            'total',
            'bulan',
            'tahun'
        ));
    }

    // =====================
    // 🔹 EXPORT PDF
    // =====================
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // ➕ TAMBAHAN PERIODE TANGGAL
        $tanggal_awal  = Carbon::create($tahun, $bulan, 1);
        $tanggal_akhir = $tanggal_awal->copy()->endOfMonth();

        // DATA LAPORAN (TETAP)
        $data = TransaksiSampah::with(['jenis', 'nasabah'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $total = TransaksiSampah::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('SUM(uang_masuk) as masuk, SUM(uang_keluar) as keluar')
            ->first();

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'data',
            'total',
            'bulan',
            'tahun',
            'tanggal_awal',
            'tanggal_akhir'
        ));

        return $pdf->download('laporan-'.$bulan.'-'.$tahun.'.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->bulan, $request->tahun),
            'laporan.xlsx'
        );
    }
}
