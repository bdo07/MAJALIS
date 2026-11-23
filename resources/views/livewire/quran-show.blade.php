<div class="py-8" dir="rtl" x-data="{ 
    isPlaying: false, 
    audio: null, 
    copiedAyah: null,
    lastReadAyah: 1,
    progress: 0,
    currentTimeFormatted: '00:00',
    durationFormatted: '00:00',

    init() {
        this.audio = this.$refs.audioElement;
        const hash = window.location.hash;
        let initialAyah = 1;
        if (hash && hash.startsWith('#ayah-')) {
            const parsed = parseInt(hash.replace('#ayah-', ''));
            if (!isNaN(parsed)) initialAyah = parsed;
        }
        this.savePosition(initialAyah);
    },
    savePosition(ayahNum) {
        this.lastReadAyah = ayahNum;
        try {
            const item = {
                surahNumber: {{ $surah['number'] }},
                surahName: '{{ addslashes($surah['name']) }}',
                ayahNumber: ayahNum,
                timestamp: Date.now(),
                url: window.location.href.split('#')[0] + (ayahNum > 1 ? '#ayah-' + ayahNum : '')
            };
            localStorage.setItem('majalis_last_read', JSON.stringify(item));
        } catch(e) {}
    },
    togglePlay() {
        if (!this.audio) return;
        if (this.audio.paused) {
            this.audio.play();
            this.isPlaying = true;
        } else {
            this.audio.pause();
            this.isPlaying = false;
        }
    },
    updateTime() {
        if (!this.audio || isNaN(this.audio.duration)) return;
        this.progress = (this.audio.currentTime / this.audio.duration) * 100;
        this.currentTimeFormatted = this.formatSeconds(this.audio.currentTime);
        this.durationFormatted = this.formatSeconds(this.audio.duration);
    },
    seek(event) {
        if (!this.audio || isNaN(this.audio.duration)) return;
        const rect = event.currentTarget.getBoundingClientRect();
        const pos = (event.clientX - rect.left) / rect.width;
        this.audio.currentTime = pos * this.audio.duration;
    },
    formatSeconds(seconds) {
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m}:${s < 10 ? '0' : ''}${s}`;
    },
    copyVerse(text, surahName, ayahNum) {
        const full = `﴿ ${text} ﴾ [${surahName}: ${ayahNum}]`;
        navigator.clipboard.writeText(full);
        this.copiedAyah = ayahNum;
        setTimeout(() => this.copiedAyah = null, 2500);
    }
}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 pb-24">
        
        <!-- Breadcrumbs & Nav Buttons -->
        <div class="flex items-center justify-between text-xs text-stone-500 dark:text-zinc-400">
            <nav class="flex items-center gap-2">
                <a href="{{ route('majalis.index') }}" class="hover:text-emerald-700 dark:hover:text-emerald-400 transition">الرئيسية</a>
                <span class="text-stone-300 dark:text-zinc-700">/</span>
                <a href="{{ route('quran.index') }}" class="hover:text-emerald-700 dark:hover:text-emerald-400 transition">المصحف الشريف</a>
                <span class="text-stone-300 dark:text-zinc-700">/</span>
                <span class="text-stone-800 dark:text-zinc-200 font-semibold">{{ $surah['name'] }}</span>
            </nav>

            <div class="flex items-center gap-2 font-medium">
                @if($neighbors['prev'])
                    <a href="{{ route('quran.show', $neighbors['prev']) }}" 
                       class="px-2.5 py-1 rounded-lg border border-stone-200 dark:border-zinc-800 hover:border-emerald-600 dark:hover:border-emerald-500 transition text-xs flex items-center gap-1">
                        <span>→</span>
                        <span class="hidden sm:inline">السورة السابقة</span>
                    </a>
                @endif
                @if($neighbors['next'])
                    <a href="{{ route('quran.show', $neighbors['next']) }}" 
                       class="px-2.5 py-1 rounded-lg border border-stone-200 dark:border-zinc-800 hover:border-emerald-600 dark:hover:border-emerald-500 transition text-xs flex items-center gap-1">
                        <span class="hidden sm:inline">السورة التالية</span>
                        <span>←</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Surah Heading Card -->
        <header class="bg-white dark:bg-[#18191d] rounded-2xl p-8 sm:p-10 border border-stone-200/80 dark:border-zinc-800 text-center space-y-4 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-stone-100 dark:bg-zinc-800/80 text-stone-700 dark:text-zinc-300 text-xs font-semibold">
                <span>سورة رقم {{ $surah['number'] }}</span>
                <span>•</span>
                <span>{{ ($surah['revelationType'] ?? '') === 'Meccan' ? 'مكية' : 'مدنية' }}</span>
                <span>•</span>
                <span>{{ $surah['numberOfAyahs'] }} آية</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-bold font-serif text-stone-900 dark:text-zinc-100 tracking-wide">
                {{ $surah['name'] }}
            </h1>

            <p class="text-xs sm:text-sm text-stone-500 dark:text-zinc-400 font-sans">
                {{ $surah['englishName'] }} • {{ $surah['englishNameTranslation'] }}
            </p>

            <!-- Surah Bookmark & Action Button -->
            <div class="pt-2 flex items-center justify-center gap-3">
                @auth
                    <button wire:click="toggleSurahBookmark" 
                            class="px-4 py-2 rounded-xl border text-xs font-semibold transition flex items-center gap-1.5 {{ $this->isSurahBookmarked ? 'bg-amber-100 dark:bg-amber-950/60 border-amber-300 dark:border-amber-700 text-amber-800 dark:text-amber-300' : 'bg-stone-50 dark:bg-zinc-800 border-stone-200 dark:border-zinc-700 text-stone-700 dark:text-zinc-300 hover:border-amber-500' }}">
                        <span>{{ $this->isSurahBookmarked ? '★ سورة محفوظة' : '☆ حفظ السورة في المحفوظات' }}</span>
                    </button>
                @endauth
            </div>

            @if(session()->has('bookmark_message'))
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-xs font-medium">
                    {{ session('bookmark_message') }}
                </div>
            @endif
        </header>

        <!-- Related Majlis Study Circle Banner (If Active) -->
        @if(count($relatedMajalis) > 0)
            <div class="p-5 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/20 border border-emerald-200/70 dark:border-emerald-900/40 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-sm shrink-0">
                        📖
                    </span>
                    <div>
                        <div class="text-xs sm:text-sm font-bold text-stone-900 dark:text-zinc-100">
                            يوجد مجلس تدبر قائم لهذه السورة الكريمة
                        </div>
                        <div class="text-xs text-stone-600 dark:text-zinc-400 mt-0.5">
                            منهج الإمام فريد الأنصاري • تدبرات القراء • الهدايات السلوكية
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @foreach($relatedMajalis as $m)
                        <a href="{{ route('majalis.show', $m) }}" 
                           class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl transition shadow-sm whitespace-nowrap">
                            دخول المجلس ←
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reader Controls Toolbar (Sticky) -->
        <div class="sticky top-16 z-30 bg-white/95 dark:bg-[#18191d]/95 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-wrap items-center justify-between gap-3 text-xs">
            
            <!-- View Mode Switcher -->
            <div class="flex items-center gap-1 bg-stone-100 dark:bg-zinc-800 p-1 rounded-xl">
                <button wire:click="setViewMode('verse_by_verse')" 
                        class="px-3 py-1.5 rounded-lg font-semibold transition {{ $viewMode === 'verse_by_verse' ? 'bg-white dark:bg-zinc-700 text-stone-900 dark:text-white shadow-sm' : 'text-stone-600 dark:text-zinc-400' }}">
                    📜 قراءة الآيات المستقلة
                </button>
                <button wire:click="setViewMode('mushaf')" 
                        class="px-3 py-1.5 rounded-lg font-semibold transition {{ $viewMode === 'mushaf' ? 'bg-white dark:bg-zinc-700 text-stone-900 dark:text-white shadow-sm' : 'text-stone-600 dark:text-zinc-400' }}">
                    📖 وضع المصحف المتصل
                </button>
            </div>

            <!-- Features Controls: Tafsir & Audio & Font Size -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Tafsir Toggle Button -->
                <button wire:click="toggleTafsir" 
                        class="px-3 py-1.5 rounded-xl border text-xs font-semibold transition flex items-center gap-1.5 {{ $showTafsir ? 'bg-emerald-700 text-white border-emerald-700' : 'bg-stone-50 dark:bg-zinc-800 border-stone-200 dark:border-zinc-700 text-stone-700 dark:text-zinc-300 hover:border-emerald-600' }}">
                    <span>📚</span>
                    <span>التفسير الميسر</span>
                    <span class="text-[10px] opacity-80">{{ $showTafsir ? 'مفعل' : 'مخفي' }}</span>
                </button>

                <!-- Reciter Selection Dropdown -->
                <div class="relative">
                    <select wire:model.live="reciter" 
                            class="py-1.5 px-3 text-xs bg-stone-50 dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700 rounded-xl text-stone-700 dark:text-zinc-300 focus:ring-emerald-700">
                        @foreach($reciters as $key => $r)
                            <option value="{{ $key }}">{{ $r['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Font Size Controls -->
                <div class="hidden sm:flex items-center gap-1 border-r border-stone-200 dark:border-zinc-800 pr-2">
                    <button wire:click="setFontSize('small')" class="px-2 py-1 rounded text-xs {{ $fontSize === 'small' ? 'bg-stone-200 dark:bg-zinc-700 font-bold' : 'text-stone-500' }}">صغير</button>
                    <button wire:click="setFontSize('normal')" class="px-2 py-1 rounded text-xs {{ $fontSize === 'normal' ? 'bg-stone-200 dark:bg-zinc-700 font-bold' : 'text-stone-500' }}">متوسط</button>
                    <button wire:click="setFontSize('large')" class="px-2 py-1 rounded text-xs {{ $fontSize === 'large' ? 'bg-stone-200 dark:bg-zinc-700 font-bold' : 'text-stone-500' }}">كبير</button>
                </div>
            </div>
        </div>

        @php
            $textSizeClass = match($fontSize) {
                'small' => 'text-xl sm:text-2xl leading-[2.4]',
                'large' => 'text-3xl sm:text-4xl leading-[2.8]',
                'xl' => 'text-4xl sm:text-5xl leading-[3.0]',
                default => 'text-2xl sm:text-3xl leading-[2.6]',
            };
        @endphp

        <!-- Quran Reading Surface -->
        <main class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-6 sm:p-12 space-y-8 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
            
            <!-- Bismillah Header (Except Surah 9) -->
            @if($surah['number'] !== 9)
                <div class="text-center py-4 border-b border-stone-100 dark:border-zinc-800/80">
                    <div class="font-quran text-2xl sm:text-3xl text-stone-800 dark:text-zinc-200 font-bold select-none tracking-wide">
                        بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                    </div>
                </div>
            @endif

            <!-- View Mode 1: Verse by Verse List -->
            @if($viewMode === 'verse_by_verse')
                <div class="space-y-6">
                    @foreach($surah['ayahs'] as $ayah)
                        @php
                            $text = $ayah['text'];
                            if ($surah['number'] !== 1 && $ayah['numberInSurah'] === 1 && str_starts_with($text, 'بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ ')) {
                                $text = substr($text, strlen('بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ '));
                            }
                            $tafsirText = $tafsirMap[$ayah['numberInSurah']] ?? null;
                        @endphp
                        
                        <div id="ayah-{{ $ayah['numberInSurah'] }}" 
                             class="p-6 rounded-2xl bg-stone-50/50 dark:bg-zinc-800/30 border border-stone-200/60 dark:border-zinc-800 space-y-4 transition"
                             :class="lastReadAyah === {{ $ayah['numberInSurah'] }} ? 'ring-2 ring-emerald-600/30 dark:ring-emerald-500/30' : ''">
                            <!-- Ayah Header -->
                            <div class="flex items-center justify-between text-xs text-stone-400 dark:text-zinc-500 border-b border-stone-200/50 dark:border-zinc-800/60 pb-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-emerald-800 dark:text-emerald-400">
                                        الآية {{ $ayah['numberInSurah'] }}
                                    </span>
                                    <template x-if="lastReadAyah === {{ $ayah['numberInSurah'] }}">
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-semibold">
                                            موضع قراءتك
                                        </span>
                                    </template>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Mark as Last Read -->
                                    <button @click="savePosition({{ $ayah['numberInSurah'] }})" 
                                            class="hover:text-emerald-700 dark:hover:text-emerald-400 transition flex items-center gap-1 font-medium text-xs"
                                            :class="lastReadAyah === {{ $ayah['numberInSurah'] }} ? 'text-emerald-700 dark:text-emerald-400 font-bold' : ''"
                                            title="حفظ موضع التوقف">
                                        <span x-show="lastReadAyah === {{ $ayah['numberInSurah'] }}">📍 توقفت هنا</span>
                                        <span x-show="lastReadAyah !== {{ $ayah['numberInSurah'] }}">🔖 وضع علامة</span>
                                    </button>

                                    @auth
                                        <!-- Bookmark Ayah Button -->
                                        <button wire:click="toggleAyahBookmark({{ $ayah['numberInSurah'] }}, '{{ addslashes($text) }}')"
                                                class="hover:text-amber-600 dark:hover:text-amber-400 transition flex items-center gap-1 font-medium text-xs {{ in_array($ayah['numberInSurah'], $this->bookmarkedAyahs) ? 'text-amber-600 dark:text-amber-400 font-bold' : '' }}"
                                                title="حفظ الآية في المفضلة">
                                            <span>{{ in_array($ayah['numberInSurah'], $this->bookmarkedAyahs) ? '★ محفوظة' : '☆ حفظ' }}</span>
                                        </button>
                                    @endauth

                                    <button @click="copyVerse('{{ addslashes($text) }}', '{{ $surah['name'] }}', {{ $ayah['numberInSurah'] }})" 
                                            class="hover:text-stone-700 dark:hover:text-zinc-200 transition flex items-center gap-1 font-medium">
                                        <span x-show="copiedAyah !== {{ $ayah['numberInSurah'] }}">📋 نسخ</span>
                                        <span x-show="copiedAyah === {{ $ayah['numberInSurah'] }}" class="text-emerald-700 dark:text-emerald-400 font-bold">✓ تم النسخ</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Ayah Quranic Text -->
                            <div class="font-quran {{ $textSizeClass }} text-stone-900 dark:text-zinc-100 text-right leading-loose">
                                {{ $text }}
                            </div>

                            <!-- Classical Tafsir Al-Muyassar (If Enabled) -->
                            @if($showTafsir && $tafsirText)
                                <div class="mt-4 p-4 rounded-xl bg-white dark:bg-zinc-900/80 border border-stone-200/70 dark:border-zinc-800 text-xs sm:text-sm text-stone-700 dark:text-zinc-300 leading-relaxed font-sans">
                                    <div class="font-bold text-emerald-800 dark:text-emerald-400 text-xs mb-1">
                                        التفسير الميسر:
                                    </div>
                                    <p>{{ $tafsirText }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- View Mode 2: Continuous Mushaf Flow -->
            @if($viewMode === 'mushaf')
                <div class="font-quran {{ $textSizeClass }} text-justify leading-loose text-stone-900 dark:text-zinc-100 tracking-wide select-text">
                    @foreach($surah['ayahs'] as $ayah)
                        @php
                            $text = $ayah['text'];
                            if ($surah['number'] !== 1 && $ayah['numberInSurah'] === 1 && str_starts_with($text, 'بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ ')) {
                                $text = substr($text, strlen('بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ '));
                            }
                        @endphp
                        <span>{{ $text }}</span>
                        <span class="inline-flex items-center justify-center mx-1 text-emerald-800 dark:text-emerald-400 font-mono text-sm align-middle select-none">
                            <span class="border border-stone-300 dark:border-zinc-700 rounded-full px-2 py-0.5 text-xs bg-stone-100 dark:bg-zinc-800">
                                ۝ {{ $ayah['numberInSurah'] }}
                            </span>
                        </span>
                    @endforeach
                </div>
            @endif

        </main>

        <!-- Bottom Navigation -->
        <div class="p-6 bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 flex items-center justify-between gap-4 text-xs font-semibold text-stone-700 dark:text-zinc-300">
            @if($neighbors['prev'])
                <a href="{{ route('quran.show', $neighbors['prev']) }}" 
                   class="px-4 py-2 rounded-xl bg-stone-100 dark:bg-zinc-800 hover:bg-stone-200 transition flex items-center gap-1.5">
                    <span>→</span>
                    <span>السورة السابقة</span>
                </a>
            @else
                <div></div>
            @endif

            <a href="{{ route('quran.index') }}" class="text-emerald-700 dark:text-emerald-400 hover:underline">
                فهرس سور القرآن الكريم (114)
            </a>

            @if($neighbors['next'])
                <a href="{{ route('quran.show', $neighbors['next']) }}" 
                   class="px-4 py-2 rounded-xl bg-stone-100 dark:bg-zinc-800 hover:bg-stone-200 transition flex items-center gap-1.5">
                    <span>السورة التالية</span>
                    <span>←</span>
                </a>
            @else
                <div></div>
            @endif
        </div>

    </div>

    <!-- Hidden Native Audio Element -->
    <audio x-ref="audioElement" 
           src="{{ $audioUrl }}" 
           preload="none"
           @timeupdate="updateTime()"
           @ended="isPlaying = false; progress = 0"
           class="hidden"></audio>

    <!-- Floating Dock Audio Player Bar (Sticky at Bottom) -->
    <div class="fixed bottom-0 inset-x-0 z-50 bg-white/95 dark:bg-[#18191d]/95 backdrop-blur-md border-t border-stone-200/80 dark:border-zinc-800 px-4 py-3 shadow-lg">
        <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Left Info -->
            <div class="flex items-center gap-3">
                <button @click="togglePlay" 
                        class="w-10 h-10 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white flex items-center justify-center shadow-sm transition active:scale-95">
                    <svg x-show="!isPlaying" class="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.5 3.5v13l11-6.5-11-6.5z" />
                    </svg>
                    <svg x-show="isPlaying" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z" />
                    </svg>
                </button>

                <div class="text-right text-xs">
                    <div class="font-bold text-stone-900 dark:text-zinc-100">
                        تلاوة {{ $surah['name'] }}
                    </div>
                    <div class="text-[11px] text-stone-500 dark:text-zinc-400">
                        القارئ: {{ $reciters[$reciter]['name'] ?? 'العفاسي' }}
                    </div>
                </div>
            </div>

            <!-- Center Progress Bar -->
            <div class="flex-1 max-w-md hidden sm:flex items-center gap-3">
                <span class="text-[11px] font-mono text-stone-400" x-text="currentTimeFormatted">00:00</span>
                <div @click="seek($event)" class="flex-1 h-1.5 bg-stone-200 dark:bg-zinc-800 rounded-full cursor-pointer overflow-hidden">
                    <div class="h-full bg-emerald-700 rounded-full transition-all duration-100" :style="`width: ${progress}%`"></div>
                </div>
                <span class="text-[11px] font-mono text-stone-400" x-text="durationFormatted">--:--</span>
            </div>

            <!-- Right Status -->
            <div class="text-xs text-stone-500 font-mono">
                <span x-text="isPlaying ? 'جاري الاستماع...' : 'متوقف'"></span>
            </div>

        </div>
    </div>
</div>
