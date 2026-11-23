<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="rtl"
      x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }" 
      x-init="$watch('theme', val => localStorage.setItem('theme', val))" 
      x-bind:class="theme === 'dark' ? 'dark' : ''">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'مجالس القرآن الكريم') }}</title>

        <!-- Google Fonts: Cairo & Amiri Quran -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Prevent Theme Flash -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#fbfbfa] dark:bg-[#121316] text-[#24292e] dark:text-[#e4e5e7] min-h-screen flex flex-col justify-between selection:bg-emerald-700 selection:text-white">
        <div class="flex-grow">
            @include('layouts.navigation')
            <livewire:global-search />

            @isset($header)
                <header class="bg-white/90 dark:bg-[#18191d]/90 backdrop-blur-md border-b border-stone-200/70 dark:border-zinc-800">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        @include('layouts.footer')
    </body>
</html>
