<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('build/assets/styles.min.css') }}">
</head>
<body class="font-sans antialiased dark:bg-gray-900">
    @include('layouts.navigation')
    @include('layouts.components.sidebar')

    @hasSection('header')
        <header class=" dark:bg-gray-800 shadow" style="margin-left: 250px;">
            <div class="max-w-7xl mx-auto py-6 px-4">
                @yield('header')
            </div>
        </header>
    @endif

    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>