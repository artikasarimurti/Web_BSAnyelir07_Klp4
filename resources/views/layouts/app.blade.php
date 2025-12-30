<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BSU Anyelir 07') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- Navbar full width --}}
        @include('layouts.navigation')

        <div class="flex flex-1">

            {{-- Sidebar di bawah navbar --}}
            <div class="flex-shrink-0">
                @include('layouts.sidebar')
            </div>

            {{-- Main Content --}}
            <main class="flex-1 bg-gray-100 p-6">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
