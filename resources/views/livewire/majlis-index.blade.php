<div class="py-10" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Section: المنصة والمنهج -->
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950 text-white p-8 sm:p-12 shadow-xl shadow-emerald-950/20">
            <!-- Decorative Glow & Vector Shapes -->
            <div class="absolute -top-24 -left-24 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-700/60 border border-emerald-500/40 text-emerald-200 text-xs font-semibold backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>منهج الإمام الدكتور فريد الأنصاري رحمه الله</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-bold font-serif tracking-tight leading-tight">
                    مجالس القرآن الكريم
                </h1>

                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed font-sans">
                    مدارسة إيمانية لكتاب الله؛ ننطلق فيها من التلاوة المرتلة، إلى البيان الإيماني، فالتدبر التزكوي القلبي، وصولاً إلى فقه الهدايات والعمل بالقرآن في واقع الحياة.
                </p>

                <!-- Platform Stats Grid -->
                <div class="pt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 border-t border-emerald-700/60">
                    <div class="p-3 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-amber-300 font-mono">{{ $stats['majalis_count'] }}</div>
                        <div class="text-xs text-emerald-200 mt-0.5">مجلساً علمياً</div>
                    </div>
                    <div class="p-3 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-amber-300 font-mono">{{ $stats['ayat_count'] }}</div>
                        <div class="text-xs text-emerald-200 mt-0.5">مقاطع وآيات</div>
                    </div>
                    <div class="p-3 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-amber-300 font-mono">{{ $stats['tadabburat_count'] }}</div>
                        <div class="text-xs text-emerald-200 mt-0.5">تدبراً إيمانياً</div>
                    </div>
                    <div class="p-3 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-amber-300 font-mono">{{ $stats['hidayat_count'] }}</div>
                        <div class="text-xs text-emerald-200 mt-0.5">هدايات سلوكية</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                
                <!-- Search Input with Clear Button -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" 
                           type="search" 
                           class="w-full pr-10 pl-10 py-3 text-sm bg-gray-50 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700/80 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-900 dark:text-gray-100 placeholder-gray-400 transition" 
                           placeholder="ابحث عن مجلس، آية، سورة، أو كلمة مفتاحية...">
                    
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Sort & Actions -->
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <select wire:model.live="sortBy" 
                                class="py-3 px-4 pe-9 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="latest">الأحدث إضافة</option>
                            <option value="popular">الأكثر تدبراً وتفاعلاً</option>
                        </select>
                    </div>

                    @if($search || $surah || $sortBy !== 'latest')
                        <button wire:click="clearFilters" 
                                class="px-3.5 py-3 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/60 rounded-xl transition flex items-center gap-1.5 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span>إعادة تعيين</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Surah Quick Filter Pills -->
            @if(count($availableSurahs) > 0)
                <div class="flex items-center gap-2 overflow-x-auto pt-2 pb-1 scrollbar-none text-xs">
                    <span class="text-gray-400 dark:text-gray-500 whitespace-nowrap font-medium">السور:</span>
                    <button wire:click="$set('surah', '')" 
                            class="px-3 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ empty($surah) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                        الكل
                    </button>
                    @foreach($availableSurahs as $s)
                        <button wire:click="$set('surah', '{{ $s }}')" 
                                class="px-3 py-1.5 rounded-full font-medium transition whitespace-nowrap {{ $surah === $s ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            سورة {{ $s }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Majalis Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($majalis as $majlis)
                <article class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800/80 shadow-sm hover:shadow-xl hover:border-emerald-500/40 dark:hover:border-emerald-500/40 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    
                    <!-- Card Top Accent Bar -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 via-teal-500 to-amber-400"></div>

                    <div class="p-6 space-y-4 flex-1 flex flex-col">
                        <!-- Top Meta Header -->
                        <div class="flex items-center justify-between text-xs">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                #{{ $majlis->slug }}
                            </span>

                            <span class="text-gray-400 dark:text-gray-500 text-[11px]">
                                {{ $majlis->created_at?->locale('ar')->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-bold font-serif text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">
                            <a href="{{ route('majalis.show', $majlis) }}">
                                {{ $majlis->title }}
                            </a>
                        </h2>

                        <!-- Description Excerpt -->
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed line-clamp-3 flex-1">
                            {{ $majlis->description }}
                        </p>

                        <!-- Statistics Pills -->
                        <div class="flex items-center gap-2 pt-2 text-xs">
                            <span class="stat-badge bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-slate-300" title="عدد المقاطع القرآنية">
                                <span>📖</span>
                                <span>{{ $majlis->ayat_count }} مقطع</span>
                            </span>
                            <span class="stat-badge bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300" title="عدد التدبرات الإيمانية">
                                <span>💡</span>
                                <span>{{ $majlis->tadabburat_count }} تدبر</span>
                            </span>
                            <span class="stat-badge bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300" title="عدد الهدايات السلوكية">
                                <span>🌱</span>
                                <span>{{ $majlis->hidayat_count }} هداية</span>
                            </span>
                        </div>
                    </div>

                    <!-- Card Action Footer -->
                    <div class="px-6 py-4 bg-gray-50/70 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-500/60"></span>
                            <span>إشراف: {{ $majlis->user->name ?? 'المشرف العام' }}</span>
                        </div>

                        <a href="{{ route('majalis.show', $majlis) }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition-all group-hover:scale-105 duration-150">
                            <span>دخـول المجلس</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl">
                        🔍
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">لم نجد أي نتائج مطابقة</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                        @if($search || $surah)
                            لم يعثر على مجالس تطابق معايير البحث الحالية. جرب البحث بكلمات أخرى أو أعد تعيين التصفية.
                        @else
                            لا توجد مجالس منشورة حالياً في المنصة.
                        @endif
                    </p>
                    @if($search || $surah)
                        <button wire:click="clearFilters" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">
                            عرض جميع المجالس
                        </button>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $majalis->links() }}
        </div>

        <!-- Educational Section: منهج مجالس القرآن -->
        <div class="rounded-3xl bg-gradient-to-br from-emerald-50/80 via-white to-amber-50/60 dark:from-gray-900 dark:via-gray-900/90 dark:to-emerald-950/20 border border-emerald-100 dark:border-gray-800 p-8 sm:p-10 space-y-6">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">فلسفة المنصة</span>
                <h3 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 dark:text-white">أركان السير القرآني في المجلس</h3>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    كيف تستفيد من المجلس القرآني لتحقيق النقلة الإيمانية والسلوكية؟
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                <div class="p-6 bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-lg">
                        ١
                    </div>
                    <h4 class="font-bold text-base text-gray-900 dark:text-white">التلاوة والبيان التأسيسي</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        استماع وتلاوة خاشعة للآيات الكريمة، والوقوف على البيان العام ومقاصد السورة ومناسبة التنزيل.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-lg">
                        ٢
                    </div>
                    <h4 class="font-bold text-base text-gray-900 dark:text-white">التدبر وتزكية القلب</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        تأمل لطائف الكلمات القرآنية ودلالات التراكيب، وتنزيل المعاني على أحوال النفس والقلب لمعالجتها.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800/80 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-950/80 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-lg">
                        ٣
                    </div>
                    <h4 class="font-bold text-base text-gray-900 dark:text-white">الهدايات والعمل السلوكي</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        تحويل المعاني والتدبرات إلى قرارات عملية وواجبات سلوكية وأخلاق قرآنية تطبق في المعاش اليومي.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
