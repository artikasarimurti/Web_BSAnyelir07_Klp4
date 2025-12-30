<div class="mb-3 d-flex gap-2">
    <a href="{{ route('laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
       class="btn btn-danger">
        Export PDF
    </a>

    <a href="{{ route('laporan.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
       class="btn btn-success">
        Export Excel
    </a>
</div>
