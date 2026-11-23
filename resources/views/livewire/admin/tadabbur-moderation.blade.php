<div class="py-10" dir="rtl" x-data="{ confirmRejectOpen: false, rejectType: 'tadabbur', rejectId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100/70 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-xs font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>قسم الرقابة والاعتماد</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 dark:text-white">
                    مراجعة تدبرات وهدايات المجتمع
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                    فحص واعتماد المشاركات الإيمانية والسلوكية لضمان سلامة المنهج ومطابقتها لمقاصد الآيات
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.majalis.index') }}" 
                   class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition flex items-center gap-2">
                    <span>📚</span>
                    <span>إدارة المجالس</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span>✅</span>
                <span>{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span>🗑️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Tab Bar -->
        <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3">
            <button wire:click="switchTab('tadabburat')" 
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'tadabburat' ? 'bg-amber-500 text-gray-900 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>💡 تدبرات معلقة</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'tadabburat' ? 'bg-amber-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ $counts['pending_tadabburat'] }}
                </span>
            </button>

            <button wire:click="switchTab('hidayat')" 
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'hidayat' ? 'bg-teal-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>🌱 هدايات معلقة</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'hidayat' ? 'bg-teal-700 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ $counts['pending_hidayat'] }}
                </span>
            </button>

            <button wire:click="switchTab('approved')" 
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition flex items-center gap-2 {{ $activeTab === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span>✓ سجل المعتمد</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'approved' ? 'bg-emerald-700 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    {{ $counts['approved_total'] }}
                </span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="space-y-4">
            
            <!-- Pending Tadabburat Tab -->
            @if($activeTab === 'tadabburat')
                @forelse($pendingTadabburat as $tadabbur)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 font-bold text-xs flex items-center justify-center">
                                    {{ mb_substr($tadabbur->user->name, 0, 1, 'UTF-8') }}
                                </div>
                                <div>
                                    <span class="font-bold text-sm text-gray-900 dark:text-white">{{ $tadabbur->user->name }}</span>
                                    <span class="text-xs text-gray-400 font-mono ms-2">({{ $tadabbur->created_at->locale('ar')->diffForHumans() }})</span>
                                </div>
                            </div>

                            <a href="{{ route('majalis.show', $tadabbur->majlis) }}" target="_blank" 
                               class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline font-semibold">
                                المجلس: {{ $tadabbur->majlis->title }} ↗
                            </a>
                        </div>

                        <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed p-4 bg-slate-50 dark:bg-gray-800/60 rounded-xl border border-gray-100 dark:border-gray-700/60">
                            {{ $tadabbur->content }}
                        </p>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button @click="confirmRejectOpen = true; rejectType = 'tadabbur'; rejectId = {{ $tadabbur->id }}"
                                    class="px-4 py-2 rounded-xl border border-red-200 dark:border-red-900 text-red-600 dark:text-red-400 text-xs font-semibold hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                                🗑️ رفض وحذف
                            </button>
                            <button wire:click="approve({{ $tadabbur->id }})" 
                                    class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                ✅ موافقة ونشر للعامة
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-2">
                        <span class="text-3xl block">🎉</span>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد أي تدبرات معلقة حالياً</h4>
                        <p class="text-xs text-gray-400">تمت مراجعة واعتماد جميع التدبرات بنجاح.</p>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $pendingTadabburat->links() }}
                </div>
            @endif

            <!-- Pending Hidayat Tab -->
            @if($activeTab === 'hidayat')
                @forelse($pendingHidayat as $hidayah)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-950 text-teal-700 dark:text-teal-300 font-bold text-xs flex items-center justify-center">
                                    {{ mb_substr($hidayah->user->name, 0, 1, 'UTF-8') }}
                                </div>
                                <div>
                                    <span class="font-bold text-sm text-gray-900 dark:text-white">{{ $hidayah->user->name }}</span>
                                    <span class="text-xs text-gray-400 font-mono ms-2">({{ $hidayah->created_at->locale('ar')->diffForHumans() }})</span>
                                </div>
                            </div>

                            <a href="{{ route('majalis.show', $hidayah->majlis) }}" target="_blank" 
                               class="text-xs text-teal-600 dark:text-teal-400 hover:underline font-semibold">
                                المجلس: {{ $hidayah->majlis->title }} ↗
                            </a>
                        </div>

                        <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed p-4 bg-slate-50 dark:bg-gray-800/60 rounded-xl border border-gray-100 dark:border-gray-700/60">
                            {{ $hidayah->content }}
                        </p>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button @click="confirmRejectOpen = true; rejectType = 'hidayah'; rejectId = {{ $hidayah->id }}"
                                    class="px-4 py-2 rounded-xl border border-red-200 dark:border-red-900 text-red-600 dark:text-red-400 text-xs font-semibold hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                                🗑️ رفض وحذف
                            </button>
                            <button wire:click="approveHidayah({{ $hidayah->id }})" 
                                    class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                ✅ موافقة ونشر للعامة
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-2">
                        <span class="text-3xl block">🌿</span>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد أي هدايات معلقة للمراجعة</h4>
                        <p class="text-xs text-gray-400">جميع الهدايات السلوكية معتمدة أو تم التعامل معها.</p>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $pendingHidayat->links() }}
                </div>
            @endif

            <!-- Approved History Tab -->
            @if($activeTab === 'approved')
                @forelse($approvedTadabburat as $tadabbur)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-800 dark:text-gray-200">{{ $tadabbur->user->name }}</span>
                                <span class="text-gray-400">• {{ $tadabbur->created_at->format('Y-m-d') }}</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-semibold text-[11px]">
                                معتمد ومنشور
                            </span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm leading-relaxed">
                            {{ $tadabbur->content }}
                        </p>
                        <div class="text-[11px] text-gray-400 flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-800">
                            <span>المجلس: {{ $tadabbur->majlis->title }}</span>
                            <span>❤️ {{ $tadabbur->likes_count }} إعجاب</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">
                        لا توجد عناصر مسجلة.
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $approvedTadabburat->links() }}
                </div>
            @endif

        </div>

        <!-- Reject Confirmation Modal (Alpine) -->
        <div x-show="confirmRejectOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 border border-gray-100 dark:border-gray-800">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-950 text-red-600 flex items-center justify-center text-xl">
                    🗑️
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white text-base">هل أنت متأكد من رفض وحذف هذه المشاركة؟</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    سيتم حذفها نهائياً ولن تظهر في المجلس أو في مساهمات المستخدم.
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button @click="confirmRejectOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300">
                        إلغاء
                    </button>
                    <button @click="if (rejectType === 'tadabbur') { $wire.reject(rejectId); } else { $wire.rejectHidayah(rejectId); } confirmRejectOpen = false" 
                            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                        نعم، احذف
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
