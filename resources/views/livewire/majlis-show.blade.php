<div class="py-10" dir="rtl" x-data="{ copied: false }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <a href="{{ route('majalis.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('majalis.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">المجالس القرآنية</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-gray-200 font-semibold truncate">{{ $majlis->title }}</span>
        </nav>

        <!-- Majlis Header Card -->
        <header class="relative rounded-3xl bg-gradient-to-br from-white via-white to-emerald-50/50 dark:from-gray-900 dark:via-gray-900 dark:to-emerald-950/20 p-8 sm:p-10 border border-emerald-100 dark:border-gray-800 shadow-sm space-y-6 overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/70 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>مجلس قرآني مدارسي</span>
                </div>

                <!-- Copy Link Button with Alpine Feedback -->
                <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:border-emerald-500 transition shadow-sm">
                    <svg x-show="!copied" class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                    <span x-show="!copied">مشاركة رابط المجلس</span>
                    <span x-show="copied" class="text-emerald-600 dark:text-emerald-400 font-bold">✓ تم نسخ الرابط!</span>
                </button>
            </div>

            <div class="space-y-3">
                <h1 class="text-2xl sm:text-4xl font-bold font-serif text-gray-900 dark:text-white leading-tight">
                    {{ $majlis->title }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base leading-relaxed">
                    {{ $majlis->description }}
                </p>
            </div>

            <!-- Meta details & stats bar -->
            <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center justify-between gap-4 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5">
                        <span class="text-emerald-600 dark:text-emerald-400">👤</span>
                        <span>إشراف: <strong class="text-gray-700 dark:text-gray-200">{{ $majlis->user->name ?? 'المشرف العام' }}</strong></span>
                    </span>
                    <span>•</span>
                    <span>نُشر {{ $majlis->created_at?->locale('ar')->diffForHumans() }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="stat-badge bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300">
                        📖 {{ $majlis->ayat->count() }} مقطع
                    </span>
                    <span class="stat-badge bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300">
                        💡 {{ $majlis->tadabburat->count() }} تدبر
                    </span>
                    <span class="stat-badge bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300">
                        🌱 {{ $majlis->hidayat->count() }} هداية
                    </span>
                </div>
            </div>
        </header>

        <!-- Global Flash Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-sm flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="text-lg">✅</span>
                <span>{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('hidayat_message'))
            <div class="p-4 bg-teal-50 dark:bg-teal-950/50 border border-teal-200 dark:border-teal-800 text-teal-800 dark:text-teal-200 rounded-2xl text-sm flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="text-lg">🌿</span>
                <span>{{ session('hidayat_message') }}</span>
            </div>
        @endif

        <!-- Quranic Passages Section (الآيات والبيان) -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold font-serif text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400">📖</span>
                    <span>الآيات القرآنية والبيان التأسيسي</span>
                </h2>
                <span class="text-xs text-gray-500">منهج التلقي القرآني</span>
            </div>

            @forelse($majlis->ayat as $ayah)
                <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden space-y-6 p-6 sm:p-8">
                    
                    <!-- Surah & Verse Range Badge -->
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <div class="inline-flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="font-bold text-base text-gray-900 dark:text-white font-serif">
                                سورة {{ $ayah->surah_name }}
                            </span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-mono">
                                الآيات: {{ $ayah->from_ayah }} - {{ $ayah->to_ayah }}
                            </span>
                        </div>
                    </div>

                    <!-- Quranic Scripture Text with Uthmani Styling -->
                    <div class="quran-ayah-box">
                        <!-- Ornamental Bismillah Header if Surah opening -->
                        @if($ayah->from_ayah == 1 && $ayah->surah_name !== 'التوبة' && !str_contains($ayah->quranic_text, 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ'))
                            <div class="text-center font-quran text-lg text-emerald-700/80 dark:text-emerald-300/80 mb-4 select-none">
                                بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                            </div>
                        @endif

                        <div class="quran-verse">
                            {{ $ayah->quranic_text }}
                        </div>
                    </div>

                    <!-- Bayan: البيان العام والتأسيس الإيماني -->
                    @if($ayah->bayan_text)
                        <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 dark:bg-gray-800/60 border border-slate-100 dark:border-gray-800 space-y-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase tracking-wide">
                                <span>🌿</span>
                                <span>البيان العام والتأسيس الإيماني (منهج المدارسة)</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line font-sans">
                                {{ $ayah->bayan_text }}
                            </p>
                        </div>
                    @endif

                </div>
            @empty
                <div class="p-8 text-center bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 text-gray-500">
                    لم تتم إضافة أي مقاطع قرآنية لهذا المجلس بعد.
                </div>
            @endforelse
        </section>

        <!-- Community Section: Interactive Tabs -->
        <section class="space-y-6 pt-4">
            
            <!-- Navigation Tabs Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 dark:border-gray-800 pb-4">
                <div class="flex items-center gap-2">
                    <!-- Tab 1: التدبرات -->
                    <button wire:click="setTab('tadabburat')" 
                            class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'tadabburat' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        <span>💡 تدبرات القراء</span>
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'tadabburat' ? 'bg-emerald-700 text-emerald-100' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                            {{ $majlis->tadabburat->count() }}
                        </span>
                    </button>

                    <!-- Tab 2: الهدايات -->
                    <button wire:click="setTab('hidayat')" 
                            class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'hidayat' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        <span>🌱 الهدايات والعمل</span>
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'hidayat' ? 'bg-teal-700 text-teal-100' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                            {{ $majlis->hidayat->count() }}
                        </span>
                    </button>
                </div>

                <!-- Tab 3: شارك معنا -->
                <button wire:click="setTab('contribute')" 
                        class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'contribute' ? 'bg-amber-500 text-gray-900 shadow-sm' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 hover:bg-amber-100' }}">
                    <span>✍️ إضافة مساهمة جديدة</span>
                </button>
            </div>

            <!-- Tab 1: التدبرات الإيمانية -->
            @if($activeTab === 'tadabburat')
                <div class="space-y-4">
                    @forelse($majlis->tadabburat as $tadabbur)
                        @php
                            $hasLiked = $tadabbur->likes->where('user_id', auth()->id())->isNotEmpty();
                        @endphp
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm hover:border-emerald-200 dark:hover:border-emerald-800 transition duration-200 space-y-4">
                            
                            <!-- User Header -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                        {{ mb_substr($tadabbur->user->name, 0, 1, 'UTF-8') }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-900 dark:text-white">{{ $tadabbur->user->name }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $tadabbur->created_at->locale('ar')->diffForHumans() }}</div>
                                    </div>
                                </div>

                                <!-- Like Button -->
                                <button wire:click="toggleLike({{ $tadabbur->id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition-transform active:scale-95 {{ $hasLiked ? 'bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900' : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-red-50 hover:text-red-600' }}"
                                        title="{{ $hasLiked ? 'إلغاء الإعجاب' : 'أعجبني هذا التدبر' }}">
                                    <span>{{ $hasLiked ? '❤️' : '🤍' }}</span>
                                    <span>{{ $tadabbur->likes_count ?? $tadabbur->likes->count() }}</span>
                                </button>
                            </div>

                            <!-- Content -->
                            <p class="text-gray-800 dark:text-gray-200 text-sm sm:text-base leading-relaxed font-sans pr-12">
                                {{ $tadabbur->content }}
                            </p>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-10 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                            <span class="text-3xl block">💡</span>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد تدبرات منشورة بعد</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">كن أول من يشارك وقفة إيمانية لطيفة حول هذا المقطع القرآني.</p>
                            <button wire:click="setTab('contribute')" class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">
                                أضف تدبرك الآن
                            </button>
                        </div>
                    @endforelse
                </div>
            @endif

            <!-- Tab 2: الهدايات والعمل بالقرآن -->
            @if($activeTab === 'hidayat')
                <div class="space-y-4">
                    @forelse($majlis->hidayat as $hidayah)
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm hover:border-teal-200 dark:hover:border-teal-800 transition duration-200 space-y-4">
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                        {{ mb_substr($hidayah->user->name, 0, 1, 'UTF-8') }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-gray-900 dark:text-white">{{ $hidayah->user->name }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $hidayah->created_at->locale('ar')->diffForHumans() }}</div>
                                    </div>
                                </div>

                                <!-- Upvote / Support Button -->
                                <button wire:click="upvoteHidayah({{ $hidayah->id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-800 hover:bg-teal-100 transition active:scale-95"
                                        title="أؤيد العمل بهذه الهداية">
                                    <span>🌱 سأعمل بها</span>
                                    <span class="font-bold">({{ $hidayah->votes_count }})</span>
                                </button>
                            </div>

                            <p class="text-gray-800 dark:text-gray-200 text-sm sm:text-base leading-relaxed font-sans pr-12">
                                {{ $hidayah->content }}
                            </p>

                            @if(session()->has('hidayat_vote_message_' . $hidayah->id))
                                <div class="text-xs text-teal-600 dark:text-teal-400 font-semibold pr-12">
                                    {{ session('hidayat_vote_message_' . $hidayah->id) }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-10 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                            <span class="text-3xl block">🌱</span>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد هدايات سلوكية معتمدة بعد</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">شاركنا قراراً سلوكياً أو خلقاً إيمانياً استنبطته من هذا المجلس.</p>
                            <button wire:click="setTab('contribute')" class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition">
                                أضف هداية عملية
                            </button>
                        </div>
                    @endforelse
                </div>
            @endif

            <!-- Tab 3: شارك معنا (Form) -->
            @if($activeTab === 'contribute')
                <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-6 sm:p-8 shadow-sm space-y-6">
                    
                    @auth
                        <!-- Contribution Type Selector -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">نوع المساهمة:</label>
                            <div class="grid grid-cols-2 gap-3 max-w-md">
                                <button type="button" wire:click="setContributionType('tadabbur')" 
                                        class="p-3 rounded-xl border text-center transition {{ $contributionType === 'tadabbur' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300 font-bold' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400' }}">
                                    <div class="text-lg mb-1">💡</div>
                                    <div class="text-xs font-semibold">تدبر إيماني / قلبي</div>
                                </button>
                                <button type="button" wire:click="setContributionType('hidayah')" 
                                        class="p-3 rounded-xl border text-center transition {{ $contributionType === 'hidayah' ? 'border-teal-500 bg-teal-50 dark:bg-teal-950/50 text-teal-800 dark:text-teal-300 font-bold' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400' }}">
                                    <div class="text-lg mb-1">🌱</div>
                                    <div class="text-xs font-semibold">هداية عملية / سلوكية</div>
                                </button>
                            </div>
                        </div>

                        <!-- Methodology Tip Box -->
                        <div class="p-4 rounded-2xl bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/50 dark:border-amber-900/40 text-xs text-amber-900 dark:text-amber-200 leading-relaxed">
                            <strong class="font-bold block mb-1">نصيحة منهجية من مجالس القرآن:</strong>
                            @if($contributionType === 'tadabbur')
                                "التدبر هو إدراك المعنى بقلب حي، ومطابقة مراد الله مع واقع نفسك، بعيداً عن التكلف أو إقحام المعاني البعيدة."
                            @else
                                "الهداية السلوكية هي تحويل الوحي إلى حركة وخلق وعمل، كأن تقرر خلقاً، أو تلزم ورداً، أو تصحح سلوكاً في ضوء الآية."
                            @endif
                        </div>

                        @if($contributionType === 'tadabbur')
                            <!-- Form Tadabbur -->
                            <form wire:submit="storeTadabbur" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                        نص التدبر الإيماني:
                                    </label>
                                    <textarea wire:model="content" rows="4" 
                                              class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 text-sm focus:ring-emerald-500 focus:border-emerald-500" 
                                              placeholder="اكتب المعنى الإيماني أو اللطيفة القرآنية التي وقفت عليها..."></textarea>
                                    @error('content') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" 
                                        class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                    إرسال التدبر للاعتماد
                                </button>
                            </form>
                        @else
                            <!-- Form Hidayah -->
                            <form wire:submit="storeHidayat" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                        الهداية أو القرار السلوكي المستفاد:
                                    </label>
                                    <textarea wire:model="newHidayatContent" rows="4" 
                                              class="w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 text-sm focus:ring-teal-500 focus:border-teal-500" 
                                              placeholder="ما هو السلوك، الواجب العملي، أو التطبيق الواقعي الذي استنبطته من الآيات؟"></textarea>
                                    @error('newHidayatContent') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" 
                                        class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                    إرسال الهداية للاعتماد
                                </button>
                            </form>
                        @endif

                    @else
                        <!-- Guest Prompt -->
                        <div class="py-12 text-center space-y-4 max-w-md mx-auto">
                            <div class="w-14 h-14 mx-auto rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl">
                                ✍️
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">انضم لمجالس القرآن وشارك تدبراتك</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                يتطلب إرسال التدبرات والهدايات تسجيل الدخول لحفظ مساهماتك وعرضها باسمك المبارك.
                            </p>
                            <div class="flex items-center justify-center gap-3 pt-2">
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    تسجيل الدخول
                                </a>
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition">
                                    إنشاء حساب جديد
                                </a>
                            </div>
                        </div>
                    @endauth

                </div>
            @endif

        </section>

    </div>
</div>
