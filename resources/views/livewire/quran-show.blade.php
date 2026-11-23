<div class="py-10" dir="rtl" x-data="{ 
    isPlaying: false, 
    audio: null, 
    currentTime: '0:00', 
    duration: '0:00',
    copiedAyah: null,
    init() {
        this.audio = this.$refs.audioPlayer;
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
    }
}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumbs Navigation -->
        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <nav class="flex items-center gap-2">
                <a href="{{ route('majalis.index') }}" class="hover:text-emerald-600 transition">الرئيسية</a>
                <span>/</span>
                <a href="{{ route('quran.index') }}" class="hover:text-emerald-600 transition">المصحف الشريف</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white font-semibold">{{ $surah['name'] }}</span>
            </nav>

            <!-- Surah Navigation Quick Arrows -->
            <div class="flex items-center gap-2">
                @if($neighbors['prev'])
                    <a href="{{ route('quran.show', $neighbors['prev']) }}" 
                       class="px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-emerald-500 transition text-xs flex items-center gap-1"
                       title="السورة السابقة">
                        <span>→</span>
                        <span class="hidden sm:inline">السورة السابقة</span>
                    </a>
                @endif
                @if($neighbors['next'])
                    <a href="{{ route('quran.show', $neighbors['next']) }}" 
                       class="px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-emerald-500 transition text-xs flex items-center gap-1"
                       title="السورة التالية">
                        <span class="hidden sm:inline">السورة التالية</span>
                        <span>←</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Surah Grand Header Card -->
        <header class="relative rounded-3xl bg-gradient-to-br from-white via-white to-emerald-50/50 dark:from-gray-900 dark:via-gray-900 dark:to-emerald-950/20 p-8 sm:p-10 border border-emerald-100 dark:border-gray-800 shadow-sm text-center space-y-4 overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/70 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-semibold">
                <span>سورة رقم {{ $surah['number'] }}</span>
                <span>•</span>
                <span>{{ ($surah['revelationType'] ?? '') === 'Meccan' ? 'مكية' : 'مدنية' }}</span>
                <span>•</span>
                <span>{{ $surah['numberOfAyahs'] }} آية</span>
            </div>

            <h1 class="text-4xl sm:text-5xl font-bold font-serif text-gray-900 dark:text-white tracking-wide">
                {{ $surah['name'] }}
            </h1>

            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-sans">
                {{ $surah['englishName'] }} ({{ $surah['englishNameTranslation'] }})
            </p>

            <!-- Audio Reciter Bar -->
            <div class="pt-4 max-w-md mx-auto">
                <audio x-ref="audioPlayer" 
                       src="{{ $audioUrl }}" 
                       preload="none"
                       @ended="isPlaying = false"
                       class="hidden"></audio>

                <div class="p-3 bg-slate-50 dark:bg-gray-800/80 rounded-2xl border border-gray-200 dark:border-gray-700 flex items-center justify-between gap-3 shadow-inner">
                    <button @click="togglePlay" 
                            class="w-10 h-10 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shadow-sm transition active:scale-95">
                        <svg x-show="!isPlaying" class="w-5 h-5 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13l11-6.5-11-6.5z" />
                        </svg>
                        <svg x-show="isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z" />
                        </svg>
                    </button>

                    <div class="flex-1 text-right text-xs">
                        <div class="font-bold text-gray-900 dark:text-white">تلاوة مرئية كاملة للسورة</div>
                        <div class="text-[11px] text-gray-500 dark:text-gray-400">بصوت الشيخ مشاري راشد العفاسي</div>
                    </div>

                    <div class="text-xs text-emerald-600 dark:text-emerald-400 font-mono font-semibold">
                        <span x-text="isPlaying ? 'جارٍ التشغيل...' : 'استمع'"></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Related Majalis Study Banner (If Available) -->
        @if(count($relatedMajalis) > 0)
            <div class="p-5 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-500/10 via-emerald-500/10 to-teal-500/10 border border-emerald-200/60 dark:border-emerald-800/40 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-right">
                    <span class="text-2xl">💡</span>
                    <div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                            توجد مجالس تدبرية ومدارسة علمية لهذه السورة!
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                            شارك في كتابة التدبرات الإيمانية والهدايات السلوكية مع المجتمع.
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @foreach($relatedMajalis as $m)
                        <a href="{{ route('majalis.show', $m) }}" 
                           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition whitespace-nowrap">
                            دخول: {{ Str::limit($m->title, 35) }} ←
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reader Controls Toolbar -->
        <div class="sticky top-20 z-40 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md p-4 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-wrap items-center justify-between gap-3 text-xs">
            
            <!-- View Mode Switcher -->
            <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
                <button wire:click="setViewMode('mushaf')" 
                        class="px-3 py-1.5 rounded-lg font-semibold transition {{ $viewMode === 'mushaf' ? 'bg-white dark:bg-gray-700 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-600 dark:text-gray-400' }}">
                    📖 وضع المصحف المتصل
                </button>
                <button wire:click="setViewMode('verse_by_verse')" 
                        class="px-3 py-1.5 rounded-lg font-semibold transition {{ $viewMode === 'verse_by_verse' ? 'bg-white dark:bg-gray-700 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-600 dark:text-gray-400' }}">
                    📜 وضع الآيات المستقلة
                </button>
            </div>

            <!-- Font Size Adjuster -->
            <div class="flex items-center gap-1.5">
                <span class="text-gray-400 font-medium">حجم الخط:</span>
                <button wire:click="setFontSize('small')" class="px-2.5 py-1 rounded-lg border text-xs {{ $fontSize === 'small' ? 'bg-emerald-50 dark:bg-emerald-950 border-emerald-500 font-bold text-emerald-600' : 'border-gray-200 dark:border-gray-700' }}">صغير</button>
                <button wire:click="setFontSize('normal')" class="px-2.5 py-1 rounded-lg border text-xs {{ $fontSize === 'normal' ? 'bg-emerald-50 dark:bg-emerald-950 border-emerald-500 font-bold text-emerald-600' : 'border-gray-200 dark:border-gray-700' }}">متوسط</button>
                <button wire:click="setFontSize('large')" class="px-2.5 py-1 rounded-lg border text-xs {{ $fontSize === 'large' ? 'bg-emerald-50 dark:bg-emerald-950 border-emerald-500 font-bold text-emerald-600' : 'border-gray-200 dark:border-gray-700' }}">كبير</button>
                <button wire:click="setFontSize('xl')" class="px-2.5 py-1 rounded-lg border text-xs {{ $fontSize === 'xl' ? 'bg-emerald-50 dark:bg-emerald-950 border-emerald-500 font-bold text-emerald-600' : 'border-gray-200 dark:border-gray-700' }}">كبير جداً</button>
            </div>
        </div>

        @php
            $textSizeClass = match($fontSize) {
                'small' => 'text-xl md:text-2xl leading-[2.4]',
                'large' => 'text-3xl md:text-4xl leading-[2.8]',
                'xl' => 'text-4xl md:text-5xl leading-[3.0]',
                default => 'text-2xl md:text-3xl leading-[2.6]',
            };
        @endphp

        <!-- Quran Reading Surface -->
        <main class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 sm:p-12 space-y-8">
            
            <!-- Bismillah Header (Except Surah 9 At-Tawbah) -->
            @if($surah['number'] !== 9)
                <div class="text-center py-4 border-b border-gray-100 dark:border-gray-800">
                    <div class="font-quran text-2xl sm:text-3xl text-emerald-700 dark:text-emerald-300 font-bold select-none tracking-wide">
                        بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                    </div>
                </div>
            @endif

            <!-- View Mode 1: Continuous Mushaf Flow -->
            @if($viewMode === 'mushaf')
                <div class="font-quran {{ $textSizeClass }} text-justify leading-loose text-gray-900 dark:text-amber-50/90 tracking-wide select-text">
                    @foreach($surah['ayahs'] as $ayah)
                        @php
                            $text = $ayah['text'];
                            // إزالة البسملة من أول الآية إذا كانت السورة ليست الفاتحة وكانت الآية 1
                            if ($surah['number'] !== 1 && $ayah['numberInSurah'] === 1 && str_starts_with($text, 'بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ ')) {
                                $text = substr($text, strlen('بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ '));
                            }
                        @endphp
                        <span>{{ $text }}</span>
                        <span class="inline-flex items-center justify-center mx-1.5 text-emerald-600 dark:text-emerald-400 font-mono text-sm align-middle select-none">
                            <span class="border border-emerald-500/40 rounded-full px-2 py-0.5 text-xs bg-emerald-50/50 dark:bg-emerald-950/40">
                                ۝ {{ $ayah['numberInSurah'] }}
                            </span>
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- View Mode 2: Verse By Verse List -->
            @if($viewMode === 'verse_by_verse')
                <div class="space-y-6">
                    @foreach($surah['ayahs'] as $ayah)
                        <div class="p-6 rounded-2xl bg-slate-50/70 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-700/60 space-y-4 hover:border-emerald-300 transition">
                            <div class="flex items-center justify-between text-xs text-gray-400 border-b border-gray-200/60 dark:border-gray-700 pb-2">
                                <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                    الآية رقم {{ $ayah['numberInSurah'] }}
                                </span>
                                
                                <div class="flex items-center gap-3">
                                    <button @click="navigator.clipboard.writeText('{{ addslashes($ayah['text']) }}'); copiedAyah = {{ $ayah['numberInSurah'] }}; setTimeout(() => copiedAyah = null, 2000)" 
                                            class="hover:text-emerald-600 transition flex items-center gap-1">
                                        <span x-show="copiedAyah !== {{ $ayah['numberInSurah'] }}">📋 نسخ</span>
                                        <span x-show="copiedAyah === {{ $ayah['numberInSurah'] }}" class="text-emerald-600 font-bold">✓ تم النسخ</span>
                                    </button>
                                </div>
                            </div>

                            <div class="font-quran {{ $textSizeClass }} text-gray-900 dark:text-amber-50 text-right leading-loose">
                                {{ $ayah['text'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </main>

        <!-- Bottom Surah Navigation Bar -->
        <div class="p-6 bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 flex items-center justify-between gap-4">
            @if($neighbors['prev'])
                <a href="{{ route('quran.show', $neighbors['prev']) }}" 
                   class="px-5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 text-xs font-semibold text-gray-700 dark:text-gray-300 transition flex items-center gap-2">
                    <span>→</span>
                    <span>السورة السابقة</span>
                </a>
            @else
                <div></div>
            @endif

            <a href="{{ route('quran.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                فهرس سور المصحف (114)
            </a>

            @if($neighbors['next'])
                <a href="{{ route('quran.show', $neighbors['next']) }}" 
                   class="px-5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 text-xs font-semibold text-gray-700 dark:text-gray-300 transition flex items-center gap-2">
                    <span>السورة التالية</span>
                    <span>←</span>
                </a>
            @else
                <div></div>
            @endif
        </div>

    </div>
</div>
