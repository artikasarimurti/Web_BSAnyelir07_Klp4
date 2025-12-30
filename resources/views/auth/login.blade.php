
@extends('layouts.login')

@section('content')

<style>
    .login-container {
        display: flex;
        width: 100%;
        height: 100vh;
        background-color: #cfe5c8;
    }

    .login-left {
        width: 50%;
        background-color: #cfe5c8;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .login-right {
        width: 50%;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
        padding: 2rem;
    }

    .login-title {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 2.5rem;
        margin-top: -1rem; /* 🔼 Naikkan ke atas */
        color: #1a1a1a;
    }

    .forgot-link {
        color: #0056ff; /* 🔹 Biru */
        font-weight: 600;
    }

    button {
        background-color: #2f4f23;
        margin-top: 20px; /* 🔽 Tambah jarak tombol */
    }
    button:hover {
        background-color: #243c1b;
    }
</style>


<div class="login-container">

    {{-- LEFT SIDE --}}
    <div class="login-left">
        <div class="login-card">

            <h2 class="login-title">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label class="text-sm font-semibold text-gray-800 mb-1 block">Email</label>
                <input type="text" name="email"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 focus:ring focus:ring-green-500 mb-6"
                    placeholder="Enter your email" required>

                <div class="flex justify-between items-center">
                    <label class="text-sm font-semibold text-gray-800 mb-1 block">Password</label>
                    <a href="{{ route('password.request') }}"
                    class="text-xs forgot-link hover:underline">
                        Forgot password?
                    </a>
                </div>
                <input type="password" name="password"
                    class="w-full px-3 py-2 rounded-md border border-gray-300 focus:ring focus:ring-green-500"
                    placeholder="Enter your password" required>

                <button type="submit"
                        class="w-full text-white py-2 font-bold rounded-md transition">
                    Login
                </button>
            </form>

            @if ($errors->any())
                <div class="mt-3 text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

        </div>
    </div>


    {{-- RIGHT SIDE IMAGE --}}
    <div class="login-right">
        <img src="{{ asset('images/trash-login.jpg') }}" class="w-[85%]" alt="Trash Image">
    </div>

</div>

@endsection
