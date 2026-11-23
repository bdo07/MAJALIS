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
                    <div class="text-xl font-bold text-amber-500 font-mono">
                        {{ auth()->user()->tadabburat()->where('status', 'pending')->count() + auth()->user()->hidayat()->where('status', 'pending')->count() }}
                    </div>
                    <div class="text-xs text-amber-700 dark:text-amber-300 mt-0.5">قيد مراجعة المشرف</div>
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
        <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3">
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

        </div>

        <!-- Delete Confirmation Modal (Alpine) -->
        <div x-show="confirmDeleteOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 border border-gray-100 dark:border-gray-800">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-950 text-red-600 flex items-center justify-center text-xl">
                    ⚠️
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white text-base">هل أنت متأكد من حذف هذه المساهمة؟</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    سيتم حذفها نهائياً من صحيفتك ومن المجلس.
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button @click="confirmDeleteOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300">
                        إلغاء
                    </button>
                    <button @click="if (deleteType === 'tadabbur') { $wire.deleteTadabbur(deleteId); } else { $wire.deleteHidayah(deleteId); } confirmDeleteOpen = false" 
                            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                        نعم، احذف
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
