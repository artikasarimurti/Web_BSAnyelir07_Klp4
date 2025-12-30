<div class="sidebar w-64 bg-[#2F855A] text-white min-h-screen p-4">
    <h1 class="text-xl font-bold mb-5">BANK SAMPAH DIGITAL</h1>

    <ul class="space-y-2">
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('dashboard') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/dashboard.png') }}" class="w-6 h-6" alt="Dashboard">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('pengurus.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('pengurus.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/user.png') }}" class="w-6 h-6" alt="Data Pengurus">
                Data Pengurus
            </a>
        </li>

        <li>
            <a href="{{ route('nasabah.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('nasabah.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/data.png') }}" class="w-6 h-6" alt="Data Nasabah">
                Data Nasabah
            </a>
        </li>

        <li>
            <a href="{{ route('jenis.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('jenis.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/wallet.png') }}" class="w-6 h-6" alt="Jenis & Harga">
                Data Sampah
            </a>
        </li>

        <li>
            <a href="{{ route('transaksi.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('transaksi.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/trash.png') }}" class="w-6 h-6" alt="Setoran">
                Setoran Sampah
            </a>
        </li>

        <li>
            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('laporan.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/report.png') }}" class="w-6 h-6" alt="Laporan">
                Laporan
            </a>
        </li>

        <li>
            <a href="{{ route('backup.index') }}"
               class="flex items-center gap-3 p-2 rounded 
               {{ request()->routeIs('backup.*') ? 'bg-green-800 font-semibold' : 'hover:bg-green-700' }}">
                <img src="{{ asset('images/backupdata.png') }}" class="w-6 h-6" alt="Backup Data">
                Backup Data
            </a>
        </li>
    </ul>
</div>
