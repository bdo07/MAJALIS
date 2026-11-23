<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'مجالس القرآن الكريم') }}</title>

        <!-- Google Fonts: Cairo & Amiri -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
    <body class="font-sans text-[#24292e] dark:text-[#e4e5e7] antialiased bg-[#fbfbfa] dark:bg-[#121316] transition-colors duration-200">
        
        <div class="min-h-screen flex flex-col justify-center items-center p-6 relative">
            
            <!-- Central Form Container -->
            <div class="w-full sm:max-w-md flex flex-col items-center relative z-10">
                
                <!-- Brand Emblem -->
                <div class="mb-6 text-center">
                    <a href="{{ route('majalis.index') }}" class="inline-flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-emerald-700 text-white rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold font-serif text-stone-900 dark:text-stone-100 mt-1">
                            مجالس القرآن الكريم
                        </span>
                        <span class="text-xs text-emerald-700 dark:text-emerald-400 font-medium">منهج التلقي والتزكية والبلاغ</span>
                    </a>
                </div>

                <!-- Form Card -->
                <div class="w-full bg-white dark:bg-[#18191d] shadow-[0_2px_8px_rgba(0,0,0,0.04)] overflow-hidden sm:rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-8 transition-colors">
                    {{ $slot }}
                </div>

                <!-- Quick Test Credentials Hint -->
                <div class="mt-4 p-3 rounded-xl bg-stone-100/70 dark:bg-zinc-800/50 border border-stone-200/60 dark:border-zinc-800 text-[11px] text-stone-500 dark:text-zinc-400 text-center w-full max-w-sm">
                    <span>حساب تجريبي سريع: </span>
                    <span class="font-mono text-emerald-700 dark:text-emerald-400 font-bold">admin@majalis.test</span>
                    <span> | السر: </span>
                    <span class="font-mono text-emerald-700 dark:text-emerald-400 font-bold">password</span>
                </div>

                <!-- Back to Home Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('majalis.index') }}" class="text-xs text-stone-500 dark:text-zinc-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition">
                        ← العودة إلى تصفح المجالس القرآنية
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
