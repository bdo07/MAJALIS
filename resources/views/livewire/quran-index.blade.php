<div class="py-10" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Hero Section: المصحف الشريف -->
        <div class="relative rounded-3xl overflow-hidden bg-[#13231c] text-white p-8 sm:p-12 border border-emerald-900/60 shadow-lg">
            <div class="relative z-10 max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-900/70 border border-emerald-700/50 text-emerald-200 text-xs font-semibold">
                    <span>📖</span>
                    <span>كتاب الله المبين • بنص عثماني موثق وتلاوة خاشعة</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-bold font-serif tracking-tight leading-tight">
                    المصحف الشريف
                </h1>

                <p class="text-emerald-100/85 text-sm sm:text-base leading-relaxed font-sans max-w-2xl">
                    تصفح سور القرآن الكريم كاملة (١١٤ سورة) بنص عثماني معتمد وتلاوة صوتية خاشعة، مع ربط السور بمجالس التدبر الإيمانية والتربوية وفق منهج مدارسة القرآن.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-6 text-xs text-emerald-200/90 font-mono">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span>١١٤ سورة كاملة</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>٦٢٣٦ آية كريمة</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                        <span>٣٠ جزءاً مباركاً</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resume Reading Card (Alpine / LocalStorage) -->
        <div x-data="{ 
            lastRead: null,
            init() {
                try {
                    this.lastRead = JSON.parse(localStorage.getItem('majalis_last_read') || 'null');
                } catch(e) {}
            },
            clearLastRead() {
                localStorage.removeItem('majalis_last_read');
                this.lastRead = null;
            }
        }" 
        x-show="lastRead" 
        x-cloak
        class="bg-white dark:bg-[#18191d] rounded-2xl border border-emerald-600/30 dark:border-emerald-500/30 p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">متابعة التلاوة من حيث توقفت</div>
                    <div class="text-base font-bold font-serif text-stone-900 dark:text-stone-100 mt-0.5">
                        <span x-text="lastRead ? lastRead.surahName : ''"></span>
                        <template x-if="lastRead && lastRead.ayahNumber > 1">
                            <span class="text-xs font-normal text-stone-500 dark:text-zinc-400" x-text="'(الآية ' + lastRead.ayahNumber + ')'"></span>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 self-end sm:self-center shrink-0">
                <a :href="lastRead ? lastRead.url : '#'" 
                   class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <span>متابعة القراءة</span>
                    <span>↗</span>
                </a>
                <button @click="clearLastRead()" 
                        class="p-2 text-stone-400 hover:text-stone-600 dark:hover:text-zinc-200 text-xs" 
                        title="إغلاق التنبيه">
                    ✕
                </button>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                
                <!-- Search Input -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.250ms="search" 
                           type="search" 
                           class="w-full pr-10 pl-10 py-3 text-sm bg-gray-50 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700/80 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-gray-900 dark:text-gray-100 placeholder-gray-400 transition" 
                           placeholder="ابحث عن اسم السورة (مثل: الفاتحة، الكهف، يس) أو رقمها (1-114)...">
                    
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            ✕
                        </button>
                    @endif
                </div>

                <!-- Revelation Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto text-xs font-semibold">
                    <button wire:click="setFilter('all')" 
                            class="px-3.5 py-2.5 rounded-xl transition whitespace-nowrap {{ $filter === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
                        جميع السور (114)
                    </button>
                    <button wire:click="setFilter('Meccan')" 
                            class="px-3.5 py-2.5 rounded-xl transition whitespace-nowrap {{ $filter === 'Meccan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
                        السور المكية (86)
                    </button>
                    <button wire:click="setFilter('Medinan')" 
                            class="px-3.5 py-2.5 rounded-xl transition whitespace-nowrap {{ $filter === 'Medinan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
                        السور المدنية (28)
                    </button>
                    <button wire:click="setFilter('juz_amma')" 
                            class="px-3.5 py-2.5 rounded-xl transition whitespace-nowrap {{ $filter === 'juz_amma' ? 'bg-amber-500 text-gray-900 shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
                        سور جزء عم (37)
                    </button>
                </div>
            </div>
        </div>

        <!-- Surahs Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($surahs as $surah)
                @php
                    $cleanName = trim(str_replace(['سُورَةُ', 'سورة', 'ٱ'], ['', '', 'ا'], $surah['name'] ?? ''));
                    $hasMajlis = in_array($cleanName, $majalisSurahs);
                @endphp
                <a href="{{ route('quran.show', $surah['number']) }}" 
                   class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800/90 p-5 shadow-sm hover:shadow-xl hover:border-emerald-500/50 dark:hover:border-emerald-500/50 transition-all duration-300 flex items-center justify-between gap-4">
                    
                    <!-- Right: Number Badge & Name Details -->
                    <div class="flex items-center gap-4">
                        <!-- Number Badge in Islamic Ornamental Ring -->
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800/40 flex items-center justify-center font-mono font-bold text-sm shadow-sm group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-200">
                            {{ $surah['number'] }}
                        </div>

                        <div>
                            <!-- Arabic Surah Name -->
                            <h2 class="text-lg font-bold font-serif text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                {{ $surah['name'] }}
                            </h2>
                            <div class="flex items-center gap-2 text-xs text-gray-400 font-sans mt-0.5">
                                <span>{{ $surah['englishName'] }}</span>
                                <span>•</span>
                                <span>{{ $surah['numberOfAyahs'] }} آية</span>
                            </div>
                        </div>
                    </div>

                    <!-- Left: Metadata & Direct Action -->
                    <div class="flex flex-col items-end gap-1.5 text-xs">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ ($surah['revelationType'] ?? '') === 'Meccan' ? 'bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/50 dark:border-amber-900/50' : 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-900/50' }}">
                            {{ ($surah['revelationType'] ?? '') === 'Meccan' ? 'مكية' : 'مدنية' }}
                        </span>

                        @if($hasMajlis)
                            <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600 dark:text-emerald-400 font-bold">
                                <span>💡</span>
                                <span>يوجد مجلس تدبر</span>
                            </span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                    <span class="text-3xl block">🔍</span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">لم يتم العثور على أي سورة</h3>
                    <p class="text-xs text-gray-400">تأكد من كتابة اسم السورة بشكل صحيح أو ابحث برقمها.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
