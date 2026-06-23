<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="font-sans antialiased bg-[#0A0A0A] text-white"
        data-toast-status="{{ session('status') }}"
        data-toast-success="{{ session('success') }}"
        data-toast-error="{{ session('error') }}"
        data-toast-errors='@json($errors->all())'
    >
        <div class="min-h-screen lg:flex">
            @include('layouts.navigation')

            <div class="flex-1">
                @isset($header)
                    <header class="border-b border-[#1F1F1F] bg-[#111111]/90 backdrop-blur">
                        <div class="px-6 py-5 lg:px-10">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
