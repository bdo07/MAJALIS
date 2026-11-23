<div x-data="{
    isOpen: false,
    query: '',
    selectedIndex: 0,
    searchData: @js($searchData),
    normalize(text) {
        if (!text) return '';
        return String(text)
            .replace(/[\u064B-\u065F\u0670]/g, '')
            .replace(/[إأآا]/g, 'ا')
            .replace(/ة/g, 'ه')
            .replace(/ى/g, 'ي')
            .replace(/[\u06D6-\u06ED]/g, '')
            .toLowerCase()
            .trim();
    },
    get results() {
        const q = this.normalize(this.query);
        if (!q) {
            return {
                majalis: this.searchData.majalis.slice(0, 3),
                surahs: this.searchData.surahs.filter(s => [1, 18, 36, 55, 67, 112].includes(s.number))
            };
        }

        const filteredMajalis = this.searchData.majalis.filter(m => {
            return this.normalize(m.title).includes(q) || this.normalize(m.description).includes(q);
        });

        const filteredSurahs = this.searchData.surahs.filter(s => {
            return this.normalize(s.name).includes(q) 
                || this.normalize(s.cleanName).includes(q)
                || (s.englishName && s.englishName.toLowerCase().includes(q))
                || String(s.number) === q;
        });

        return {
            majalis: filteredMajalis.slice(0, 5),
            surahs: filteredSurahs.slice(0, 10)
        };
    },
    get flatList() {
        const r = this.results;
        return [...r.majalis, ...r.surahs];
    },
    openPalette() {
        this.isOpen = true;
        this.selectedIndex = 0;
        this.$nextTick(() => {
            if (this.$refs.searchInput) {
                this.$refs.searchInput.focus();
                this.$refs.searchInput.select();
            }
        });
    },
    closePalette() {
        this.isOpen = false;
        this.query = '';
    },
    navigate(delta) {
        const count = this.flatList.length;
        if (count === 0) return;
        this.selectedIndex = (this.selectedIndex + delta + count) % count;
    },
    selectCurrent() {
        const item = this.flatList[this.selectedIndex];
        if (item && item.url) {
            window.location.href = item.url;
        }
    }
}"
@open-search.window="openPalette()"
@keydown.window.prevent.cmd.k="openPalette()"
@keydown.window.prevent.ctrl.k="openPalette()"
class="relative z-50"
dir="rtl">

    <!-- Modal Backdrop & Dialog -->
    <div x-show="isOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-stone-900/60 dark:bg-black/75 backdrop-blur-sm flex items-start justify-center pt-16 sm:pt-24 px-4 pb-6 overflow-y-auto"
         @click.self="closePalette()"
         @keydown.escape.window="closePalette()">
        
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="w-full max-w-2xl bg-[#fbfbfa] dark:bg-[#18191d] rounded-2xl shadow-2xl border border-stone-200 dark:border-zinc-800 overflow-hidden flex flex-col max-h-[80vh]">

            <!-- Search Header Bar -->
            <div class="p-4 border-b border-stone-200/80 dark:border-zinc-800 flex items-center gap-3 bg-white dark:bg-[#151619]">
                <div class="text-stone-400 dark:text-zinc-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input x-ref="searchInput"
                       x-model="query"
                       @keydown.down.prevent="navigate(1)"
                       @keydown.up.prevent="navigate(-1)"
                       @keydown.enter.prevent="selectCurrent()"
                       type="text" 
                       placeholder="ابحث عن سورة بالاسم أو الرقم، أو مجلس قرآني..."
                       class="w-full bg-transparent border-0 text-base text-stone-900 dark:text-stone-100 placeholder-stone-400 dark:placeholder-zinc-500 focus:ring-0 focus:outline-none font-sans" />

                <div class="flex items-center gap-1.5 shrink-0">
                    <span class="px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-[11px] font-mono text-stone-500 dark:text-zinc-400 border border-stone-200 dark:border-zinc-700">
                        ESC
                    </span>
                    <button @click="closePalette()" class="p-1 text-stone-400 hover:text-stone-600 dark:hover:text-zinc-200 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Results Container -->
            <div class="p-3 overflow-y-auto divide-y divide-stone-100 dark:divide-zinc-800/60 space-y-3">

                <!-- Majalis Results -->
                <div x-show="results.majalis.length > 0" class="pt-2">
                    <div class="px-3 pb-2 text-[11px] font-bold text-stone-400 dark:text-zinc-500 uppercase tracking-wider flex items-center justify-between">
                        <span>المجالس القرآنية</span>
                        <span x-text="results.majalis.length + ' مجلس'"></span>
                    </div>

                    <div class="space-y-1">
                        <template x-for="(majlis, idx) in results.majalis" :key="'majlis-' + idx">
                            <a :href="majlis.url" 
                               class="group flex items-center justify-between p-3 rounded-xl transition duration-150"
                               :class="flatList.indexOf(majlis) === selectedIndex 
                                        ? 'bg-emerald-700 text-white' 
                                        : 'hover:bg-stone-100 dark:hover:bg-zinc-800/70 text-stone-900 dark:text-stone-100'"
                               @mouseenter="selectedIndex = flatList.indexOf(majlis)">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                         :class="flatList.indexOf(majlis) === selectedIndex 
                                                    ? 'bg-white/20 text-white' 
                                                    : 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold font-serif" x-text="majlis.title"></div>
                                        <div class="text-xs line-clamp-1" 
                                             :class="flatList.indexOf(majlis) === selectedIndex ? 'text-emerald-100' : 'text-stone-500 dark:text-zinc-400'"
                                             x-text="majlis.description"></div>
                                    </div>
                                </div>
                                <span class="text-xs shrink-0 font-medium opacity-80">انتقال ↗</span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Surahs Results -->
                <div x-show="results.surahs.length > 0" class="pt-3">
                    <div class="px-3 pb-2 text-[11px] font-bold text-stone-400 dark:text-zinc-500 uppercase tracking-wider flex items-center justify-between">
                        <span x-text="query ? 'السور القرآنية المطابقة' : 'سور مقترحة للقراءة والتأمل'"></span>
                        <span x-text="results.surahs.length + ' سورة'"></span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                        <template x-for="(surah, idx) in results.surahs" :key="'surah-' + idx">
                            <a :href="surah.url" 
                               class="group flex items-center justify-between p-2.5 rounded-xl transition duration-150"
                               :class="flatList.indexOf(surah) === selectedIndex 
                                        ? 'bg-emerald-700 text-white' 
                                        : 'hover:bg-stone-100 dark:hover:bg-zinc-800/70 text-stone-900 dark:text-stone-100'"
                               @mouseenter="selectedIndex = flatList.indexOf(surah)">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-md flex items-center justify-center font-mono text-xs font-bold shrink-0"
                                          :class="flatList.indexOf(surah) === selectedIndex 
                                                    ? 'bg-white/20 text-white' 
                                                    : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300'"
                                          x-text="surah.number"></span>
                                    <div>
                                        <div class="text-sm font-bold font-serif" x-text="surah.name"></div>
                                        <div class="text-[11px]"
                                             :class="flatList.indexOf(surah) === selectedIndex ? 'text-emerald-100' : 'text-stone-500 dark:text-zinc-400'">
                                            <span x-text="surah.revelation"></span> • <span x-text="surah.ayahs + ' آية'"></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs shrink-0 font-medium opacity-80">تلاوة ↗</span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- No Results State -->
                <div x-show="flatList.length === 0" class="py-12 text-center text-stone-400 dark:text-zinc-500 space-y-2">
                    <span class="text-3xl block">🔍</span>
                    <p class="text-sm font-medium">لم يتم العثور على سورة أو مجلس مطابق لـ "<span class="font-bold text-stone-700 dark:text-stone-300" x-text="query"></span>"</p>
                    <p class="text-xs">جرب البحث برقم السورة (مثلاً: 18) أو باسمها بدون همزات.</p>
                </div>
            </div>

            <!-- Footer Keyboard Hints -->
            <div class="p-3 bg-stone-100/70 dark:bg-[#121316] border-t border-stone-200/80 dark:border-zinc-800 flex items-center justify-between text-[11px] text-stone-500 dark:text-zinc-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1">
                        <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700 font-mono">↑</kbd>
                        <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700 font-mono">↓</kbd>
                        للتنقل
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="px-1.5 py-0.5 rounded bg-white dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700 font-mono">↵</kbd>
                        للاختيار
                    </span>
                </div>
                <span>مجالس القرآن الكريم • 114 سورة</span>
            </div>
        </div>
    </div>
</div>
