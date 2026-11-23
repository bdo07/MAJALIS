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
    <body class="font-sans text-gray-900 antialiased bg-slate-50 dark:bg-gray-950 transition-colors duration-200">
        
        <div class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-hidden">
            
            <!-- Subtle Decorative Islamic Glow Background -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Central Form Container -->
            <div class="w-full sm:max-w-md flex flex-col items-center relative z-10">
                
                <!-- Brand Emblem -->
                <div class="mb-6 text-center">
                    <a href="{{ route('majalis.index') }}" class="inline-flex flex-col items-center gap-2 group">
                        <div class="p-3.5 bg-gradient-to-tr from-emerald-600 to-emerald-500 rounded-2xl text-white shadow-lg shadow-emerald-600/30 transition-transform duration-300 group-hover:scale-105">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold font-serif text-gray-900 dark:text-white mt-1">
                            مجالس القرآن الكريم
                        </span>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">منهج الإمام فريد الأنصاري</span>
                    </a>
                </div>

                <!-- Form Card -->
                <div class="w-full bg-white dark:bg-gray-900 shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-800 p-8 transition-colors">
                    {{ $slot }}
                </div>

                <!-- Back to Home Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('majalis.index') }}" class="text-xs text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                        ← العودة إلى الصفحة الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
