<nav x-data="{ open: false, adminOpen: false }" class="sticky top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800/80 transition-colors duration-200" dir="rtl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Left Side: Brand Logo & Navigation Links -->
            <div class="flex items-center gap-8">
                <!-- Platform Brand Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('majalis.index') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-gray-900 dark:text-white font-serif tracking-wide leading-tight group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                مجالس القرآن
                            </span>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-sans">مدارسة وتدبر</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center gap-1">
                    <!-- المجالس (All Users) -->
                    <a href="{{ route('majalis.index') }}" 
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('majalis.*') && !request()->routeIs('admin.*') ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800/60' }}">
                        <span>المجالس القرآنية</span>
                    </a>

                    @auth
                        <!-- مساهماتي (Authenticated User) -->
                        <a href="{{ route('my-contributions') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('my-contributions') ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800/60' }}">
                            <span>مساهماتي الإيمانية</span>
                        </a>

                        <!-- Admin Management Links (Admins Only) -->
                        @if(auth()->user()->isAdmin())
                            <div class="relative" x-data="{ openMenu: false }">
                                <button @click="openMenu = !openMenu" @click.outside="openMenu = false"
                                        class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-150 flex items-center gap-1.5 {{ request()->routeIs('admin.*') ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800/60' }}">
                                    <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>لوحة الإشراف</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openMenu" x-cloak
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 py-2 z-50">
                                    <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 text-xs font-semibold text-gray-400">
                                        أدوات المشرف
                                    </div>
                                    <a href="{{ route('admin.majalis.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-600 transition">
                                        <span>📚</span>
                                        <span>إدارة المجالس والآيات</span>
                                    </a>
                                    <a href="{{ route('admin.tadabburat.pending') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-600 transition">
                                        <div class="flex items-center gap-2">
                                            <span>⚖️</span>
                                            <span>مراجعة التدبرات</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side: Dark Mode Toggle & Auth Controls -->
            <div class="hidden sm:flex items-center gap-3">
                <!-- Theme Switcher Button -->
                <button @click="theme = theme === 'dark' ? 'light' : 'dark'" 
                        class="p-2.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition duration-150 ease-in-out focus:outline-none"
                        title="تبديل المظهر">
                    <svg x-show="theme === 'dark'" class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                    </svg>
                    <svg x-show="theme === 'light'" class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                @auth
                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ userMenu: false }">
                        <button @click="userMenu = !userMenu" @click.outside="userMenu = false" 
                                class="flex items-center gap-2.5 p-1.5 ps-3 rounded-full border border-gray-200 dark:border-gray-700 hover:border-emerald-500/50 dark:hover:border-emerald-500/50 bg-white dark:bg-gray-800 transition duration-150">
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-200">
                                {{ Auth::user()->name }}
                            </span>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                {{ mb_substr(Auth::user()->name, 0, 1, 'UTF-8') }}
                            </div>
                        </button>

                        <div x-show="userMenu" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 py-2 z-50">
                            
                            <div class="px-4 py-2.5 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-xs text-gray-500 dark:text-gray-400">مرحباً بك</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                @if(auth()->user()->isAdmin())
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded">مشرف النظام</span>
                                @else
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">عضو متدبر</span>
                                @endif
                            </div>

                            <a href="{{ route('my-contributions') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-600 transition">
                                <span>🌱</span>
                                <span>مساهماتي الإيمانية</span>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-600 transition">
                                <span>⚙️</span>
                                <span>الملف الشخصي والإعدادات</span>
                            </a>

                            @if(auth()->user()->isAdmin())
                                <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>
                                <a href="{{ route('admin.majalis.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition">
                                    <span>🛡️</span>
                                    <span>لوحة إدارة المجالس</span>
                                </a>
                            @endif

                            <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                                    <span>🚪</span>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-3.5 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-sm font-semibold rounded-xl shadow-sm shadow-emerald-600/30 transition hover:shadow-md">
                            إنشاء حساب
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex items-center sm:hidden gap-2">
                <button @click="theme = theme === 'dark' ? 'light' : 'dark'" 
                        class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                    <svg x-show="theme === 'dark'" class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                    <svg x-show="theme === 'light'" class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                <button @click="open = !open" class="p-2 rounded-xl text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div x-show="open" x-cloak class="sm:hidden border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="px-4 pt-3 pb-3 space-y-1">
            <a href="{{ route('majalis.index') }}" 
               class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('majalis.*') && !request()->routeIs('admin.*') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40' : 'text-gray-700 dark:text-gray-300' }}">
                📖 المجالس القرآنية
            </a>

            @auth
                <a href="{{ route('my-contributions') }}" 
                   class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('my-contributions') ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40' : 'text-gray-700 dark:text-gray-300' }}">
                    🌱 مساهماتي الإيمانية
                </a>

                @if(auth()->user()->isAdmin())
                    <div class="pt-2 pb-1 border-t border-gray-100 dark:border-gray-800 text-xs font-bold text-gray-400 px-3">
                        إدارة المشرف
                    </div>
                    <a href="{{ route('admin.majalis.index') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                        📚 إدارة المجالس والآيات
                    </a>
                    <a href="{{ route('admin.tadabburat.pending') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                        ⚖️ مراجعة التدبرات والهدايات
                    </a>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-3 border-t border-gray-100 dark:border-gray-800">
            @auth
                <div class="px-4 mb-3">
                    <div class="font-bold text-base text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="px-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        ⚙️ إعدادات الحساب
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-right block px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30">
                            🚪 تسجيل الخروج
                        </button>
                    </form>
                </div>
            @else
                <div class="px-4 py-2 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 rounded-xl">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-xl shadow-sm">
                        إنشاء حساب جديد
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
