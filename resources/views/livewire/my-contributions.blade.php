<div class="py-10" dir="rtl" x-data="{ confirmDeleteOpen: false, deleteType: 'tadabbur', deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header & User Stats -->
        <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/70 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-semibold mb-2">
                        <span>🌱</span>
                        <span>صحيفة أعمالك في المنصة</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 dark:text-white">
                        مساهماتي وتدبراتي الإيمانية
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                        تتبع حالة تدبراتك وهداياتك وتفاعل المجتمع القرآني معها
                    </p>
                </div>

                <a href="{{ route('majalis.index') }}" 
                   class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-2">
                    <span>📖</span>
                    <span>تصفح مجالس القرآن للمشاركة</span>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                <div class="p-4 bg-slate-50 dark:bg-gray-800/60 rounded-2xl border border-slate-100 dark:border-gray-700/60">
                    <div class="text-xl font-bold text-gray-900 dark:text-white font-mono">
                        {{ auth()->user()->tadabburat()->count() }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">إجمالي التدبرات</div>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-gray-800/60 rounded-2xl border border-slate-100 dark:border-gray-700/60">
                    <div class="text-xl font-bold text-gray-900 dark:text-white font-mono">
                        {{ auth()->user()->hidayat()->count() }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">إجمالي الهدايات</div>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-gray-800/60 rounded-2xl border border-slate-100 dark:border-gray-700/60">
                    <div class="text-xl font-bold text-emerald-600 dark:text-emerald-400 font-mono">
                        {{ auth()->user()->tadabburat()->where('status', 'approved')->count() + auth()->user()->hidayat()->where('status', 'approved')->count() }}
                    </div>
                    <div class="text-xs text-emerald-700 dark:text-emerald-300 mt-0.5">مساهمات معتمدة ومنشورة</div>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-gray-800/60 rounded-2xl border border-slate-100 dark:border-gray-700/60">
                    <div class="text-xl font-bold text-amber-600 dark:text-amber-400 font-mono">
                        {{ auth()->user()->bookmarks()->count() }}
                    </div>
                    <div class="text-xs text-amber-700 dark:text-amber-300 mt-0.5">محفوظاتي المرجعية</div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span>✅</span>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <!-- Tab Controls -->
        <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3">
            <button wire:click="switchTab('tadabburat')" 
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $tab === 'tadabburat' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>💡 تدبراتي الإيمانية</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $tab === 'tadabburat' ? 'bg-emerald-700 text-emerald-100' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ auth()->user()->tadabburat()->count() }}
                </span>
            </button>

            <button wire:click="switchTab('hidayat')" 
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $tab === 'hidayat' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>🌱 هداياتي العملية</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $tab === 'hidayat' ? 'bg-teal-700 text-teal-100' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ auth()->user()->hidayat()->count() }}
                </span>
            </button>

            <button wire:click="switchTab('bookmarks')" 
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $tab === 'bookmarks' ? 'bg-stone-800 dark:bg-stone-200 text-white dark:text-stone-900 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>📑 محفوظاتي المرجعية</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $tab === 'bookmarks' ? 'bg-stone-700 dark:bg-stone-300 text-stone-100 dark:text-stone-800' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ auth()->user()->bookmarks()->count() }}
                </span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="space-y-4">
            
            @if($tab === 'tadabburat')
                @forelse($tadabburat as $tadabbur)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm hover:border-emerald-200 dark:hover:border-emerald-800 transition space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-3">
                                @if($tadabbur->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-xs font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        منشور للعامة
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 text-xs font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        قيد مراجعة المشرف
                                    </span>
                                @endif

                                <span class="text-xs text-gray-400 font-mono">
                                    {{ $tadabbur->created_at->locale('ar')->diffForHumans() }}
                                </span>
                            </div>

                            @if($tadabbur->majlis)
                                <a href="{{ route('majalis.show', $tadabbur->majlis) }}" 
                                   class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline font-semibold flex items-center gap-1">
                                    <span>المجلس: {{ $tadabbur->majlis->title }}</span>
                                    <span>↗</span>
                                </a>
                            @endif
                        </div>

                        <p class="text-gray-800 dark:text-gray-200 text-sm sm:text-base leading-relaxed font-sans">
                            {{ $tadabbur->content }}
                        </p>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500">
                            <span>❤️ {{ $tadabbur->likes_count ?? 0 }} إعجاب</span>

                            <button @click="confirmDeleteOpen = true; deleteType = 'tadabbur'; deleteId = {{ $tadabbur->id }}"
                                    class="text-red-500 hover:text-red-700 text-xs font-semibold hover:underline">
                                حذف التدبر
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                        <span class="text-3xl block">💡</span>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">لم تضف أي تدبرات إيمانية بعد</h4>
                        <p class="text-xs text-gray-400">تصفح المجالس القرآنية، وتأمل الآيات، وشاركنا بفتوحاتك الإيمانية.</p>
                        <a href="{{ route('majalis.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition mt-2">
                            تصفح المجالس للمشاركة
                        </a>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $tadabburat->links() }}
                </div>
            @endif

            @if($tab === 'hidayat')
                @forelse($hidayat as $hidayah)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm hover:border-teal-200 dark:hover:border-teal-800 transition space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-3">
                                @if($hidayah->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800 dark:bg-teal-950 dark:text-teal-300 text-xs font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                        منشور للعامة
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 text-xs font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        قيد مراجعة المشرف
                                    </span>
                                @endif

                                <span class="text-xs text-gray-400 font-mono">
                                    {{ $hidayah->created_at->locale('ar')->diffForHumans() }}
                                </span>
                            </div>

                            @if($hidayah->majlis)
                                <a href="{{ route('majalis.show', $hidayah->majlis) }}" 
                                   class="text-xs text-teal-600 dark:text-teal-400 hover:underline font-semibold flex items-center gap-1">
                                    <span>المجلس: {{ $hidayah->majlis->title }}</span>
                                    <span>↗</span>
                                </a>
                            @endif
                        </div>

                        <p class="text-gray-800 dark:text-gray-200 text-sm sm:text-base leading-relaxed font-sans">
                            {{ $hidayah->content }}
                        </p>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500">
                            <span>🌱 {{ $hidayah->votes_count }} أيدوا العمل بها</span>

                            <button @click="confirmDeleteOpen = true; deleteType = 'hidayah'; deleteId = {{ $hidayah->id }}"
                                    class="text-red-500 hover:text-red-700 text-xs font-semibold hover:underline">
                                حذف الهداية
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                        <span class="text-3xl block">🌱</span>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">لم تضف أي هدايات عملية بعد</h4>
                        <p class="text-xs text-gray-400">حول تدبرك لكتاب الله إلى سلوك وقرار عملي تشاركه مع إخوانك في المجالس.</p>
                        <a href="{{ route('majalis.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-semibold transition mt-2">
                            تصفح المجالس للمشاركة
                        </a>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $hidayat->links() }}
                </div>
            @endif

            @if($tab === 'bookmarks')
                <!-- Bookmark Sub-filter Chips -->
                <div class="flex items-center gap-2 pb-2">
                    <button wire:click="setBookmarkFilter('all')" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $bookmarkType === 'all' ? 'bg-emerald-600 text-white' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700' }}">
                        الكل ({{ auth()->user()->bookmarks()->count() }})
                    </button>
                    <button wire:click="setBookmarkFilter('majlis')" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $bookmarkType === 'majlis' ? 'bg-emerald-600 text-white' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700' }}">
                        المجالس ({{ auth()->user()->bookmarks()->where('type', 'majlis')->count() }})
                    </button>
                    <button wire:click="setBookmarkFilter('surah')" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $bookmarkType === 'surah' ? 'bg-emerald-600 text-white' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700' }}">
                        السور ({{ auth()->user()->bookmarks()->where('type', 'surah')->count() }})
                    </button>
                    <button wire:click="setBookmarkFilter('ayah')" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $bookmarkType === 'ayah' ? 'bg-emerald-600 text-white' : 'bg-stone-100 dark:bg-zinc-800 text-stone-600 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700' }}">
                        الآيات ({{ auth()->user()->bookmarks()->where('type', 'ayah')->count() }})
                    </button>
                </div>

                @forelse($bookmarks as $bm)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-stone-200/80 dark:border-zinc-800 p-5 shadow-sm hover:border-emerald-600/40 dark:hover:border-emerald-500/40 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $bm->type === 'majlis' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' }}">
                                    {{ $bm->type_label }}
                                </span>
                                <span class="text-xs text-stone-400 font-mono">
                                    {{ $bm->created_at->locale('ar')->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold font-serif text-stone-900 dark:text-stone-100">
                                {{ $bm->title }}
                            </h3>

                            @if($bm->subtitle)
                                <p class="text-xs text-stone-500 dark:text-zinc-400 font-sans line-clamp-1">
                                    {{ $bm->subtitle }}
                                </p>
                            @endif

                            @if($bm->note)
                                <div class="mt-2 p-2.5 rounded-xl bg-stone-50 dark:bg-zinc-800/60 border border-stone-200/60 dark:border-zinc-700/60 text-xs text-stone-700 dark:text-zinc-300">
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">ملاحظتك:</span> {{ $bm->note }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-center shrink-0">
                            <a href="{{ $bm->url }}" 
                               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-1.5">
                                <span>الانتقال</span>
                                <span>↗</span>
                            </a>

                            <button @click="confirmDeleteOpen = true; deleteType = 'bookmark'; deleteId = {{ $bm->id }}"
                                    class="p-2 text-stone-400 hover:text-red-600 rounded-lg transition"
                                    title="إزالة من المحفوظات">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                        <span class="text-3xl block">📑</span>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد عناصر محفوظة حتى الآن</h4>
                        <p class="text-xs text-gray-400">يمكنك حفظ المجالس القرآنية، والسور، والآيات الكريمة للرجوع إليها لاحقاً بضغطة زر واحدة.</p>
                        <div class="flex items-center justify-center gap-3 pt-2">
                            <a href="{{ route('majalis.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition">
                                تصفح المجالس
                            </a>
                            <a href="{{ route('quran.index') }}" class="px-4 py-2 border border-stone-200 dark:border-zinc-700 hover:bg-stone-50 dark:hover:bg-zinc-800 rounded-xl text-xs font-semibold transition">
                                المصحف الشريف
                            </a>
                        </div>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $bookmarks->links() }}
                </div>
            @endif

        </div>

        <!-- Delete Confirmation Modal (Alpine) -->
        <div x-show="confirmDeleteOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 border border-gray-100 dark:border-gray-800">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-950 text-red-600 flex items-center justify-center text-xl">
                    ⚠️
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white text-base">هل أنت متأكد من الحذف؟</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    سيتم إزالة هذا العنصر من قائمتك.
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button @click="confirmDeleteOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300">
                        إلغاء
                    </button>
                    <button @click="if (deleteType === 'tadabbur') { $wire.deleteTadabbur(deleteId); } else if (deleteType === 'hidayah') { $wire.deleteHidayah(deleteId); } else if (deleteType === 'bookmark') { $wire.deleteBookmark(deleteId); } confirmDeleteOpen = false" 
                            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                        نعم، احذف
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
