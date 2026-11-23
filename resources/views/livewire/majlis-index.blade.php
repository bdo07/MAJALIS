<div class="py-8" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Clean Hero Section -->
        <div class="border-b border-stone-200/80 dark:border-zinc-800 pb-10 space-y-6">
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-stone-100 dark:bg-zinc-800/80 text-stone-700 dark:text-zinc-300 text-xs font-medium">
                    <span>🌿</span>
                    <span>منهج الإمام الدكتور فريد الأنصاري رحمه الله</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-bold font-serif text-stone-900 dark:text-zinc-100 tracking-tight leading-tight">
                    مجالس القرآن الكريم
                </h1>

                <p class="text-stone-600 dark:text-zinc-400 text-sm sm:text-base leading-relaxed">
                    منصة قرآنية تعنى بمدارسة كتاب الله والانتقال بآياته من مجرد التلاوة المرتلة إلى البيان التأسيسي، فالتدبر التزكوي القلبي، وصولاً إلى فقه الهدايات والعمل بالقرآن في واقع الحياة.
                </p>
            </div>

            <!-- Crisp Metric Stats Ribbon -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
                <div class="p-4 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
                    <div class="text-2xl font-bold font-mono text-stone-900 dark:text-white">{{ $stats['majalis_count'] }}</div>
                    <div class="text-xs text-stone-500 dark:text-zinc-400 mt-1">مجلساً قرآنياً</div>
                </div>
                <div class="p-4 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
                    <div class="text-2xl font-bold font-mono text-stone-900 dark:text-white">{{ $stats['ayat_count'] }}</div>
                    <div class="text-xs text-stone-500 dark:text-zinc-400 mt-1">مقاطع وآيات مدارسة</div>
                </div>
                <div class="p-4 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
                    <div class="text-2xl font-bold font-mono text-stone-900 dark:text-white">{{ $stats['tadabburat_count'] }}</div>
                    <div class="text-xs text-stone-500 dark:text-zinc-400 mt-1">تدبراً معتمداً</div>
                </div>
                <div class="p-4 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
                    <div class="text-2xl font-bold font-mono text-stone-900 dark:text-white">{{ $stats['hidayat_count'] }}</div>
                    <div class="text-xs text-stone-500 dark:text-zinc-400 mt-1">هداية سلوكية</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white dark:bg-[#18191d] p-5 sm:p-6 rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)] space-y-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                
                <!-- Search Box -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-stone-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.250ms="search" 
                           type="search" 
                           class="w-full pr-10 pl-10 py-2.5 text-xs sm:text-sm bg-stone-50/70 dark:bg-zinc-800/60 border border-stone-200 dark:border-zinc-700/80 rounded-xl focus:ring-1 focus:ring-emerald-700 focus:border-emerald-700 text-stone-900 dark:text-zinc-100 placeholder-stone-400 transition" 
                           placeholder="ابحث عن مجلس أو كلمة مفتاحية في الآيات...">
                    
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400 hover:text-stone-600 dark:hover:text-zinc-200">
                            ✕
                        </button>
                    @endif
                </div>

                <!-- Sort & Clear -->
                <div class="flex items-center gap-2">
                    <select wire:model.live="sortBy" 
                            class="py-2.5 px-3 text-xs bg-stone-50 dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700 rounded-xl text-stone-700 dark:text-zinc-300 focus:ring-emerald-700">
                        <option value="latest">الأحدث إضافة</option>
                        <option value="popular">الأكثر تفاعلاً</option>
                    </select>

                    @if($search || $surah || $sortBy !== 'latest')
                        <button wire:click="clearFilters" 
                                class="px-3 py-2 text-xs font-medium text-stone-600 dark:text-zinc-400 hover:text-red-600 dark:hover:text-red-400 transition">
                            إلغاء التصفية
                        </button>
                    @endif
                </div>
            </div>

            <!-- Surah Filter Chips -->
            @if(count($availableSurahs) > 0)
                <div class="flex items-center gap-2 overflow-x-auto pt-1 text-xs">
                    <span class="text-stone-400 dark:text-zinc-500 whitespace-nowrap">السورة:</span>
                    <button wire:click="$set('surah', '')" 
                            class="px-3 py-1.5 rounded-lg font-medium transition whitespace-nowrap {{ empty($surah) ? 'bg-stone-900 text-white dark:bg-white dark:text-stone-900' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200' }}">
                        جميع السور
                    </button>
                    @foreach($availableSurahs as $s)
                        <button wire:click="$set('surah', '{{ $s }}')" 
                                class="px-3 py-1.5 rounded-lg font-medium transition whitespace-nowrap {{ $surah === $s ? 'bg-stone-900 text-white dark:bg-white dark:text-stone-900' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200' }}">
                            سورة {{ $s }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Majalis Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($majalis as $majlis)
                <article class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:border-emerald-700/40 dark:hover:border-emerald-600/40 transition-colors duration-200 flex flex-col justify-between overflow-hidden">
                    
                    <div class="p-6 space-y-3.5 flex-1 flex flex-col">
                        <!-- Top Meta -->
                        <div class="flex items-center justify-between text-xs text-stone-400 dark:text-zinc-500">
                            <span class="font-mono text-[11px] text-emerald-800 dark:text-emerald-400 font-semibold">
                                #{{ $majlis->slug }}
                            </span>
                            <span>{{ $majlis->created_at?->locale('ar')->diffForHumans() }}</span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-lg font-bold font-serif text-stone-900 dark:text-zinc-100 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors leading-snug">
                            <a href="{{ route('majalis.show', $majlis) }}">
                                {{ $majlis->title }}
                            </a>
                        </h2>

                        <!-- Description -->
                        <p class="text-stone-600 dark:text-zinc-400 text-xs sm:text-sm leading-relaxed line-clamp-3 flex-1 font-sans">
                            {{ $majlis->description }}
                        </p>

                        <!-- Stats Pills -->
                        <div class="flex items-center gap-3 pt-2 text-xs text-stone-500 dark:text-zinc-400 border-t border-stone-100 dark:border-zinc-800/80">
                            <span class="flex items-center gap-1">
                                <span>📖</span>
                                <span>{{ $majlis->ayat_count }} مقطع</span>
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <span>💡</span>
                                <span>{{ $majlis->tadabburat_count }} تدبر</span>
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <span>🌱</span>
                                <span>{{ $majlis->hidayat_count }} هداية</span>
                            </span>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="px-6 py-3.5 bg-stone-50/70 dark:bg-zinc-800/40 border-t border-stone-100 dark:border-zinc-800/80 flex items-center justify-between">
                        <div class="text-[11px] text-stone-500 dark:text-zinc-400">
                            {{ $majlis->user->name ?? 'المشرف العام' }}
                        </div>

                        <a href="{{ route('majalis.show', $majlis) }}" 
                           class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-800 dark:text-emerald-400 hover:underline">
                            <span>دخول المجلس</span>
                            <span>←</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white dark:bg-[#18191d] rounded-2xl p-12 text-center border border-stone-200/80 dark:border-zinc-800 space-y-3">
                    <span class="text-2xl block">🔍</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-white">لم نجد أي مجالس مطابقة</h3>
                    <p class="text-xs text-stone-500 dark:text-zinc-400">
                        جرب البحث بكلمات أخرى أو أعد تعيين التصفية.
                    </p>
                    <button wire:click="clearFilters" class="px-4 py-2 bg-stone-900 dark:bg-white text-white dark:text-stone-900 rounded-xl text-xs font-semibold mt-2">
                        عرض جميع المجالس
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-2">
            {{ $majalis->links() }}
        </div>

        <!-- Methodology Section: Clean Editorial Guide -->
        <div class="border-t border-stone-200/80 dark:border-zinc-800 pt-12 space-y-8">
            <div class="max-w-2xl space-y-2">
                <span class="text-xs font-semibold text-emerald-800 dark:text-emerald-400 uppercase tracking-widest">منهجية المدارسة</span>
                <h3 class="text-2xl font-bold font-serif text-stone-900 dark:text-zinc-100">أركان المجلس القرآني الثلاثة</h3>
                <p class="text-xs sm:text-sm text-stone-500 dark:text-zinc-400 leading-relaxed">
                    خطوات السير في مجالس القرآن كما قررها الإمام الدكتور فريد الأنصاري رحمه الله:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 space-y-2.5">
                    <span class="text-xs font-mono font-bold text-emerald-800 dark:text-emerald-400">المرحلة الأولى</span>
                    <h4 class="font-bold text-base text-stone-900 dark:text-zinc-100">التلاوة والبيان التأسيسي</h4>
                    <p class="text-xs text-stone-600 dark:text-zinc-400 leading-relaxed font-sans">
                        استحضار الآيات وفهم البيان العام والمقصد الكلي للسورة من خلال المعاني التأسيسية الصحيحة.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 space-y-2.5">
                    <span class="text-xs font-mono font-bold text-emerald-800 dark:text-emerald-400">المرحلة الثانية</span>
                    <h4 class="font-bold text-base text-stone-900 dark:text-zinc-100">التدبر وتزكية القلب</h4>
                    <p class="text-xs text-stone-600 dark:text-zinc-400 leading-relaxed font-sans">
                        إنزال المعاني على أحوال القلب والنفس ومداواة أمراضها بنور الوحي وصدق التلقي.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 space-y-2.5">
                    <span class="text-xs font-mono font-bold text-emerald-800 dark:text-emerald-400">المرحلة الثالثة</span>
                    <h4 class="font-bold text-base text-stone-900 dark:text-zinc-100">الهدايات والعمل السلوكي</h4>
                    <p class="text-xs text-stone-600 dark:text-zinc-400 leading-relaxed font-sans">
                        تحويل المعاني والتدبرات إلى قرارات عملية وواجبات سلوكية وخلق حي ينبض بالقرآن.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
