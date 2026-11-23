<div class="py-8" dir="rtl" x-data="{ copied: false, copiedVerseId: null }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs text-stone-500 dark:text-zinc-400">
            <a href="{{ route('majalis.index') }}" class="hover:text-emerald-700 dark:hover:text-emerald-400 transition">الرئيسية</a>
            <span class="text-stone-300 dark:text-zinc-700">/</span>
            <a href="{{ route('majalis.index') }}" class="hover:text-emerald-700 dark:hover:text-emerald-400 transition">المجالس القرآنية</a>
            <span class="text-stone-300 dark:text-zinc-700">/</span>
            <span class="text-stone-800 dark:text-zinc-200 font-semibold truncate">{{ $majlis->title }}</span>
        </nav>

        <!-- Majlis Header Card -->
        <header class="bg-white dark:bg-[#18191d] rounded-2xl p-6 sm:p-10 border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)] space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300 text-xs font-medium">
                    <span>📖</span>
                    <span>مجلس مدارسة قرآنية</span>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-stone-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-xs font-semibold text-stone-700 dark:text-zinc-300 hover:border-emerald-700 transition">
                        <span x-show="!copied">🔗 نسخ رابط المجلس</span>
                        <span x-show="copied" class="text-emerald-700 dark:text-emerald-400 font-bold">✓ تم النسخ!</span>
                    </button>
                </div>
            </div>

            <div class="space-y-2.5">
                <h1 class="text-2xl sm:text-4xl font-bold font-serif text-stone-900 dark:text-zinc-100 leading-tight">
                    {{ $majlis->title }}
                </h1>
                <p class="text-stone-600 dark:text-zinc-300 text-xs sm:text-sm leading-relaxed font-sans">
                    {{ $majlis->description }}
                </p>
            </div>

            <!-- Meta details & stats bar -->
            <div class="pt-4 border-t border-stone-100 dark:border-zinc-800/80 flex flex-wrap items-center justify-between gap-4 text-xs text-stone-500 dark:text-zinc-400">
                <div class="flex items-center gap-3">
                    <span>إشراف: <strong class="text-stone-800 dark:text-zinc-200">{{ $majlis->user->name ?? 'المشرف العام' }}</strong></span>
                    <span>•</span>
                    <span>نُشر {{ $majlis->created_at?->locale('ar')->diffForHumans() }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-0.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300">
                        📖 {{ $majlis->ayat->count() }} مقطع
                    </span>
                    <span class="px-2.5 py-0.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300">
                        💡 {{ $majlis->tadabburat->count() }} تدبر
                    </span>
                    <span class="px-2.5 py-0.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300">
                        🌱 {{ $majlis->hidayat->count() }} هداية
                    </span>
                </div>
            </div>
        </header>

        <!-- Global Flash Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/40 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('hidayat_message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/40 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2">
                <span>🌿</span>
                <span>{{ session('hidayat_message') }}</span>
            </div>
        @endif

        <!-- Quranic Passages Section (الآيات والبيان) -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold font-serif text-stone-900 dark:text-zinc-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-700"></span>
                    <span>الآيات القرآنية والبيان التأسيسي</span>
                </h2>

                <!-- Tafsir Toggle -->
                <button wire:click="toggleTafsir" 
                        class="px-3 py-1.5 rounded-xl border text-xs font-semibold transition flex items-center gap-1.5 {{ $showTafsir ? 'bg-emerald-700 text-white border-emerald-700' : 'bg-white dark:bg-zinc-800 border-stone-200 dark:border-zinc-700 text-stone-700 dark:text-zinc-300 hover:border-emerald-600' }}">
                    <span>📚</span>
                    <span>التفسير الميسر</span>
                    <span class="text-[10px] opacity-80">{{ $showTafsir ? 'مفعل' : 'مخفي' }}</span>
                </button>
            </div>

            @forelse($majlis->ayat as $ayah)
                <div class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 shadow-[0_1px_3px_rgba(0,0,0,0.03)] p-6 sm:p-8 space-y-5">
                    
                    <!-- Surah Badge -->
                    <div class="flex items-center justify-between border-b border-stone-100 dark:border-zinc-800/80 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="font-bold text-sm text-stone-900 dark:text-zinc-100 font-serif">
                                سورة {{ $ayah->surah_name }}
                            </span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300 font-mono">
                                الآيات: {{ $ayah->from_ayah }} - {{ $ayah->to_ayah }}
                            </span>
                        </div>

                        <button @click="navigator.clipboard.writeText('{{ addslashes($ayah->quranic_text) }}'); copiedVerseId = {{ $ayah->id }}; setTimeout(() => copiedVerseId = null, 2500)"
                                class="text-xs text-stone-500 hover:text-stone-800 dark:hover:text-zinc-200 transition">
                            <span x-show="copiedVerseId !== {{ $ayah->id }}">📋 نسخ الآيات</span>
                            <span x-show="copiedVerseId === {{ $ayah->id }}" class="text-emerald-700 dark:text-emerald-400 font-bold">✓ تم النسخ</span>
                        </button>
                    </div>

                    <!-- Quranic Scripture Text with Uthmani Styling -->
                    <div class="p-6 rounded-2xl bg-stone-50/70 dark:bg-zinc-800/40 border border-stone-200/60 dark:border-zinc-800 text-center">
                        <div class="font-quran text-xl sm:text-2xl leading-loose text-stone-900 dark:text-zinc-100">
                            {{ $ayah->quranic_text }}
                        </div>
                    </div>

                    <!-- Classical Tafsir Al-Muyassar (If Enabled) -->
                    @if($showTafsir && isset($tafsirMap[$ayah->id]))
                        <div class="p-5 rounded-xl bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 space-y-2">
                            <div class="font-bold text-xs text-emerald-800 dark:text-emerald-400 flex items-center gap-1.5">
                                <span>📚</span>
                                <span>التفسير الميسر (مجمع الملك فهد لطباعة المصحف الشريف):</span>
                            </div>
                            <div class="space-y-2 text-xs sm:text-sm text-stone-700 dark:text-zinc-300 leading-relaxed font-sans">
                                @foreach($tafsirMap[$ayah->id] as $vNum => $tText)
                                    <div>
                                        <strong class="text-stone-900 dark:text-white font-mono">[{{ $vNum }}]</strong> {{ $tText }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Bayan: البيان العام والتأسيس الإيماني -->
                    @if($ayah->bayan_text)
                        <div class="p-5 rounded-xl bg-stone-50/50 dark:bg-zinc-800/20 border border-stone-200/50 dark:border-zinc-800 text-xs sm:text-sm text-stone-700 dark:text-zinc-300 leading-relaxed space-y-1">
                            <div class="font-bold text-xs text-stone-900 dark:text-zinc-100 flex items-center gap-1.5">
                                <span>🌿</span>
                                <span>البيان العام والتأسيس الإيماني (منهج المدارسة):</span>
                            </div>
                            <p class="whitespace-pre-line font-sans">{{ $ayah->bayan_text }}</p>
                        </div>
                    @endif

                </div>
            @empty
                <div class="p-8 text-center bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 text-stone-400 text-xs">
                    لم تتم إضافة أي مقاطع قرآنية لهذا المجلس بعد.
                </div>
            @endforelse
        </section>

        <!-- Community Section: Interactive Tabs -->
        <section class="space-y-6 pt-2">
            
            <!-- Navigation Tabs Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone-200/80 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-2">
                    <!-- Tab 1: التدبرات -->
                    <button wire:click="setTab('tadabburat')" 
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'tadabburat' ? 'bg-stone-900 text-white dark:bg-white dark:text-stone-900 shadow-sm' : 'text-stone-600 dark:text-zinc-400 hover:bg-stone-100 dark:hover:bg-zinc-800' }}">
                        <span>💡 تدبرات القراء</span>
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'tadabburat' ? 'bg-stone-700 text-stone-200 dark:bg-stone-200 dark:text-stone-800' : 'bg-stone-100 dark:bg-zinc-800' }}">
                            {{ $majlis->tadabburat->count() }}
                        </span>
                    </button>

                    <!-- Tab 2: الهدايات -->
                    <button wire:click="setTab('hidayat')" 
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'hidayat' ? 'bg-stone-900 text-white dark:bg-white dark:text-stone-900 shadow-sm' : 'text-stone-600 dark:text-zinc-400 hover:bg-stone-100 dark:hover:bg-zinc-800' }}">
                        <span>🌱 الهدايات والعمل</span>
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'hidayat' ? 'bg-stone-700 text-stone-200 dark:bg-stone-200 dark:text-stone-800' : 'bg-stone-100 dark:bg-zinc-800' }}">
                            {{ $majlis->hidayat->count() }}
                        </span>
                    </button>
                </div>

                <!-- Tab 3: شارك معنا -->
                <button wire:click="setTab('contribute')" 
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-1.5 {{ $activeTab === 'contribute' ? 'bg-emerald-700 text-white shadow-sm' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-100' }}">
                    <span>✍️ إضافة تدبر أو هداية</span>
                </button>
            </div>

            <!-- Tab 1: التدبرات الإيمانية -->
            @if($activeTab === 'tadabburat')
                <div class="space-y-4">
                    @forelse($majlis->tadabburat as $tadabbur)
                        @php
                            $hasLiked = $tadabbur->likes->where('user_id', auth()->id())->isNotEmpty();
                        @endphp
                        <div class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)] space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300 flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($tadabbur->user->name, 0, 1, 'UTF-8') }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-xs sm:text-sm text-stone-900 dark:text-zinc-100">{{ $tadabbur->user->name }}</div>
                                        <div class="text-[11px] text-stone-400">{{ $tadabbur->created_at->locale('ar')->diffForHumans() }}</div>
                                    </div>
                                </div>

                                <button wire:click="toggleLike({{ $tadabbur->id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition active:scale-95 {{ $hasLiked ? 'bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900' : 'bg-stone-50 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700 hover:bg-red-50 hover:text-red-600' }}">
                                    <span>{{ $hasLiked ? '❤️' : '🤍' }}</span>
                                    <span>{{ $tadabbur->likes_count ?? $tadabbur->likes->count() }}</span>
                                </button>
                            </div>

                            <p class="text-stone-800 dark:text-zinc-200 text-xs sm:text-sm leading-relaxed font-sans pr-10">
                                {{ $tadabbur->content }}
                            </p>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-[#18191d] rounded-2xl p-10 text-center border border-stone-200/80 dark:border-zinc-800 space-y-2">
                            <span class="text-2xl block">💡</span>
                            <h4 class="font-bold text-stone-800 dark:text-zinc-200 text-sm">لا توجد تدبرات معتمدة بعد</h4>
                            <p class="text-xs text-stone-500 dark:text-zinc-400">كن أول من يشارك وقفة إيمانية لطيفة حول هذا المقطع القرآني.</p>
                        </div>
                    @endforelse
                </div>
            @endif

            <!-- Tab 2: الهدايات والعمل بالقرآن -->
            @if($activeTab === 'hidayat')
                <div class="space-y-4">
                    @forelse($majlis->hidayat as $hidayah)
                        <div class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)] space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300 flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($hidayah->user->name, 0, 1, 'UTF-8') }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-xs sm:text-sm text-stone-900 dark:text-zinc-100">{{ $hidayah->user->name }}</div>
                                        <div class="text-[11px] text-stone-400">{{ $hidayah->created_at->locale('ar')->diffForHumans() }}</div>
                                    </div>
                                </div>

                                <button wire:click="upvoteHidayah({{ $hidayah->id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 dark:bg-zinc-800 text-stone-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700 hover:border-emerald-700 transition active:scale-95"
                                        title="أؤيد العمل بهذه الهداية">
                                    <span>🌱 سأعمل بها</span>
                                    <span class="font-bold">({{ $hidayah->votes_count }})</span>
                                </button>
                            </div>

                            <p class="text-stone-800 dark:text-zinc-200 text-xs sm:text-sm leading-relaxed font-sans pr-10">
                                {{ $hidayah->content }}
                            </p>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-[#18191d] rounded-2xl p-10 text-center border border-stone-200/80 dark:border-zinc-800 space-y-2">
                            <span class="text-2xl block">🌱</span>
                            <h4 class="font-bold text-stone-800 dark:text-zinc-200 text-sm">لا توجد هدايات سلوكية معتمدة بعد</h4>
                            <p class="text-xs text-stone-500 dark:text-zinc-400">شاركنا قراراً سلوكياً أو خلقاً إيمانياً استنبطته من هذا المجلس.</p>
                        </div>
                    @endforelse
                </div>
            @endif

            <!-- Tab 3: شارك معنا (Form) -->
            @if($activeTab === 'contribute')
                <div class="bg-white dark:bg-[#18191d] rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-6 sm:p-8 shadow-[0_1px_3px_rgba(0,0,0,0.03)] space-y-5">
                    @auth
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-stone-700 dark:text-zinc-300">نوع المساهمة:</label>
                            <div class="grid grid-cols-2 gap-3 max-w-sm">
                                <button type="button" wire:click="setContributionType('tadabbur')" 
                                        class="p-2.5 rounded-xl border text-center transition {{ $contributionType === 'tadabbur' ? 'border-emerald-700 bg-emerald-50/70 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 font-bold' : 'border-stone-200 dark:border-zinc-700 text-stone-600 dark:text-zinc-400' }}">
                                    <div class="text-xs font-semibold">💡 تدبر إيماني / قلبي</div>
                                </button>
                                <button type="button" wire:click="setContributionType('hidayah')" 
                                        class="p-2.5 rounded-xl border text-center transition {{ $contributionType === 'hidayah' ? 'border-emerald-700 bg-emerald-50/70 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 font-bold' : 'border-stone-200 dark:border-zinc-700 text-stone-600 dark:text-zinc-400' }}">
                                    <div class="text-xs font-semibold">🌱 هداية عملية / سلوكية</div>
                                </button>
                            </div>
                        </div>

                        @if($contributionType === 'tadabbur')
                            <form wire:submit="storeTadabbur" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 dark:text-zinc-300 mb-1">
                                        نص التدبر الإيماني:
                                    </label>
                                    <textarea wire:model="content" rows="4" 
                                              class="w-full rounded-xl border-stone-200 dark:border-zinc-700 dark:bg-zinc-800 text-stone-900 dark:text-zinc-100 p-3.5 text-xs sm:text-sm focus:ring-1 focus:ring-emerald-700 focus:border-emerald-700" 
                                              placeholder="اكتب المعنى الإيماني أو اللطيفة التي وقفت عليها في هذه الآيات..."></textarea>
                                    @error('content') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" 
                                        class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                    إرسال التدبر للاعتماد
                                </button>
                            </form>
                        @else
                            <form wire:submit="storeHidayat" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 dark:text-zinc-300 mb-1">
                                        الهداية أو القرار السلوكي المستفاد:
                                    </label>
                                    <textarea wire:model="newHidayatContent" rows="4" 
                                              class="w-full rounded-xl border-stone-200 dark:border-zinc-700 dark:bg-zinc-800 text-stone-900 dark:text-zinc-100 p-3.5 text-xs sm:text-sm focus:ring-1 focus:ring-emerald-700 focus:border-emerald-700" 
                                              placeholder="ما هو السلوك، الواجب العملي، أو التطبيق الواقعي الذي استنبطته من الآيات؟"></textarea>
                                    @error('newHidayatContent') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" 
                                        class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                    إرسال الهداية للاعتماد
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="py-8 text-center space-y-3 max-w-sm mx-auto">
                            <h3 class="text-sm font-bold text-stone-900 dark:text-white">انضم لمجالس القرآن وشارك تدبراتك</h3>
                            <p class="text-xs text-stone-500 dark:text-zinc-400">
                                يتطلب إرسال التدبرات والهدايات تسجيل الدخول لحفظ مشاركاتك ونشرها باسمك.
                            </p>
                            <div class="flex items-center justify-center gap-3 pt-1">
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl border border-stone-200 dark:border-zinc-700 text-xs font-semibold text-stone-700 dark:text-zinc-300 hover:bg-stone-50 dark:hover:bg-zinc-800 transition">
                                    تسجيل الدخول
                                </a>
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold shadow-sm transition">
                                    إنشاء حساب
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            @endif

        </section>

    </div>
</div>
