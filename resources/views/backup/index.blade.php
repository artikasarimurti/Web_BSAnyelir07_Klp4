@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- TITLE -->
    <h1 class="text-2xl font-bold text-gray-700 mb-1">Backup Data</h1>
    <p class="text-gray-500 mb-5">Cadangkan seluruh data sistem untuk keamanan dan pemulihan</p>

    <!-- ALERT -->
    @if(session('success'))
        <div class="bg-[#d5ead6] text-[#3d5b40] p-3 rounded mb-4 border border-[#689765]">
            {{ session('success') }}
        </div>
    @endif

    <!-- STATUS CARD -->
    <div class="bg-gray-100 border border-gray-300 shadow rounded-lg p-4 flex gap-4 items-center mb-6">

        <!-- CUSTOM BACKUP ICON -->
        <img src="{{ asset('images/backup.png') }}"
     class="w-14 h-14 object-contain rounded-md" alt="Backup Icon">


        <div>
            <h3 class="text-[17px] font-semibold text-gray-700">Status Backup</h3>

            <p class="text-sm text-gray-600 mt-1">
                <strong>Backup Terakhir:</strong>
                {{ !empty($backups) ? $backups[0]['created_at'] : 'Belum ada backup' }}
            </p>

            <p class="text-sm text-gray-600">
                <strong>Ukuran File:</strong>
                {{ !empty($backups) ? $backups[0]['size'].' MB' : '-' }}
            </p>
        </div>
    </div>

    <!-- BACKUP BUTTON -->
    <a href="{{ route('backup.run') }}"
       class="inline-block text-white px-6 py-2 rounded-md text-sm font-semibold transition shadow"
       style="background:#689765;"
       onmouseover="this.style.background='#567c54'"
       onmouseout="this.style.background='#689765'">
        Backup Sekarang
    </a>

    <p class="text-xs text-gray-500 mt-2 mb-4">
        Klik tombol ini untuk mencadangkan seluruh data ke format .zip atau .sql.
    </p>

    <!-- RIWAYAT BACKUP TABLE -->
    <h2 class="text-lg font-semibold mb-2">Riwayat Backup</h2>

    <div class="border border-gray-300 rounded-lg shadow overflow-x-auto">

        <table class="w-full text-sm border-collapse">

            <!-- TABLE HEADER -->
            <thead>
                <tr class="bg-black text-white">
                    <th class="p-2 border border-gray-300 text-center">Tanggal</th>
                    <th class="p-2 border border-gray-300 text-center">Ukuran</th>
                    <th class="p-2 border border-gray-300 text-center">Opsi</th>
                </tr>
            </thead>

            <!-- DATA -->
            <tbody class="text-gray-700">
                @forelse($backups as $backup)
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="p-3 text-center">{{ $backup['created_at'] }}</td>
                        <td class="p-3 text-center">{{ $backup['size'] }} MB</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('backup.download', $backup['name']) }}"
                               class="px-4 py-1 rounded-md text-white text-sm shadow"
                               style="background:#689765;"
                               onmouseover="this.style.background='#567c54'"
                               onmouseout="this.style.background='#689765'">
                                Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            Belum ada backup tersimpan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
