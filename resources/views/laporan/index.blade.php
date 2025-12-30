@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h1 class="text-3xl font-bold">Laporan Bulanan</h1>

    <form method="GET" class="mb-4 flex gap-2">
        <select name="bulan" class="form-control w-25">
            @for($m=1; $m<=12; $m++)
                <option value="{{ sprintf('%02d',$m) }}" {{ sprintf('%02d',$m)==sprintf('%02d',$bulan) ? 'selected':'' }}>
                    {{ DateTime::createFromFormat('!m',$m)->format('F') }}
                </option>
            @endfor
        </select>

        <select name="tahun" class="form-control w-25">
            @for($y=2024; $y<=date('Y'); $y++)
                <option value="{{ $y }}" {{ $y==$tahun?'selected':'' }}>{{ $y }}</option>
            @endfor
        </select>

        <button class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-600">Filter</button>

        <a class="btn btn-danger"
           href="{{ route('laporan.pdf', ['bulan'=>sprintf('%02d',$bulan),'tahun'=>$tahun]) }}">
           PDF
        </a>

        <a class="btn btn-success"
           href="{{ route('laporan.excel', ['bulan'=>sprintf('%02d',$bulan),'tahun'=>$tahun]) }}">
           Excel
        </a>
    </form>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Jenis Sampah</th>
                <th>Total Kg</th>
                <th>Total Uang</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $i=>$row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->jenis->nama_jenis }}</td>
                <td>{{ number_format($row->total_kg, 2) }} Kg</td>
                <td>Rp {{ number_format($row->total_uang, 0, ',', '.') }}</td>
                <td>
                    @if(($total->total_kg ?? 0) > 0)
                        {{ number_format(($row->total_kg / $total->total_kg) * 100, 2) }} %
                    @else
                        0 %
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5">Tidak ada data pada bulan ini</td></tr>
            @endforelse
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="2">TOTAL</th>
                <th>{{ number_format($total->total_kg ?? 0, 2) }} Kg</th>
                <th>Rp {{ number_format($total->total_uang ?? 0, 0, ',', '.') }}</th>
                <th>100%</th>
            </tr>
        </tfoot>
    </table>

</div>
@endsection
