<div class="py-10" dir="rtl" x-data="{ confirmDeleteOpen: false, deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <a href="{{ route('admin.majalis.index') }}" class="hover:text-emerald-600 transition">إدارة المجالس</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-gray-200 font-semibold truncate">{{ $majlis->title }}</span>
            <span>/</span>
            <span>الآيات والمقاطع</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/70 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-semibold mb-2">
                    <span>📖</span>
                    <span>المجلس: {{ $majlis->title }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 dark:text-white">
                    إدارة المقاطع والآيات القرآنية
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                    إضافة الآيات الكريمة الخاصة بهذا المجلس مع البيان التأسيسي واللطائف الإيمانية
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('majalis.show', $majlis) }}" target="_blank"
                   class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    معاينة المجلس ↗
                </a>

                <button wire:click="create" 
                        class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-600/30 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>إضافة آية / مقطع جديد</span>
                </button>
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
            <div class="p-4 bg-amber-50 dark:bg-amber-950/50 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-200 rounded-2xl text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Ayat List Cards -->
        <div class="space-y-4">
            @forelse($ayat as $ayah)
                <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <h3 class="font-bold text-base text-gray-900 dark:text-white font-serif">
                                سورة {{ $ayah->surah_name }}
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-mono bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                الآيات: {{ $ayah->from_ayah }} - {{ $ayah->to_ayah }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="edit({{ $ayah->id }})" 
                                    class="px-3 py-1.5 rounded-xl border border-blue-200 dark:border-blue-900 text-blue-600 dark:text-blue-400 text-xs font-semibold hover:bg-blue-50 transition">
                                ✏️ تعديل
                            </button>
                            <button @click="confirmDeleteOpen = true; deleteId = {{ $ayah->id }}" 
                                    class="px-3 py-1.5 rounded-xl border border-red-200 dark:border-red-900 text-red-600 dark:text-red-400 text-xs font-semibold hover:bg-red-50 transition">
                                🗑️ حذف
                            </button>
                        </div>
                    </div>

                    <!-- Quranic Text -->
                    <div class="p-6 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/40 text-center">
                        <div class="font-quran text-xl sm:text-2xl leading-loose text-gray-900 dark:text-amber-100">
                            {{ $ayah->quranic_text }}
                        </div>
                    </div>

                    <!-- Bayan Text -->
                    @if($ayah->bayan_text)
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800/60 text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                            <strong class="font-bold block mb-1 text-emerald-700 dark:text-emerald-400">البيان التأسيسي:</strong>
                            {{ $ayah->bayan_text }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-12 text-center border border-gray-100 dark:border-gray-800 space-y-3">
                    <span class="text-3xl block">📖</span>
                    <h4 class="font-bold text-gray-800 dark:text-gray-200">لا توجد آيات أو مقاطع مضافة لهذا المجلس</h4>
                    <p class="text-xs text-gray-400">أضف الآيات الكريمة الأولى ليبدأ القراء بتدبرها ومدارستها.</p>
                    <button wire:click="create" class="mt-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition">
                        إضافة أول مقطع قرآني
                    </button>
                </div>
            @endforelse

            <div class="pt-4">
                {{ $ayat->links() }}
            </div>
        </div>

        <!-- Create / Edit Ayah Modal -->
        @if($isOpen)
            <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm animate-fade-in">
                <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-gray-800 space-y-6">
                    
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <h3 class="text-base font-bold font-serif text-gray-900 dark:text-white">
                            {{ $isEditMode ? 'تعديل المقطع القرآني' : 'إضافة مقطع قرآني جديد' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            ✕
                        </button>
                    </div>

                    <form wire:submit="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4 text-xs sm:text-sm">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-1">
                                <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">اسم السورة:</label>
                                <input wire:model="surah_name" type="text" 
                                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2.5 focus:ring-emerald-500 focus:border-emerald-500" 
                                       placeholder="مثال: الفاتحة">
                                @error('surah_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">من آية:</label>
                                <input wire:model="from_ayah" type="number" min="1" 
                                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2.5 focus:ring-emerald-500 focus:border-emerald-500" 
                                       placeholder="1">
                                @error('from_ayah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">إلى آية:</label>
                                <input wire:model="to_ayah" type="number" min="1" 
                                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-2.5 focus:ring-emerald-500 focus:border-emerald-500" 
                                       placeholder="7">
                                @error('to_ayah') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">النص القرآني بالرسم العثماني أو الإملائي:</label>
                            <textarea wire:model="quranic_text" rows="4" 
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 font-quran text-base focus:ring-emerald-500 focus:border-emerald-500 leading-relaxed" 
                                      placeholder="اكتب أو الصق نص الآيات الكريمة..."></textarea>
                            @error('quranic_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">البيان العام والتأسيس الإيماني (اختياري):</label>
                            <textarea wire:model="bayan_text" rows="3" 
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-emerald-500 focus:border-emerald-500" 
                                      placeholder="شرح موجز لمقصد المقطع ومناسبته التربوية لمنهج المدارسة..."></textarea>
                            @error('bayan_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-semibold text-xs hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                إلغاء
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                {{ $isEditMode ? 'حفظ التعديلات' : 'إضافة المقطع' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal (Alpine) -->
        <div x-show="confirmDeleteOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 border border-gray-100 dark:border-gray-800">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-950 text-red-600 flex items-center justify-center text-xl">
                    ⚠️
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white text-base">هل أنت متأكد من حذف هذه الآية؟</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    سيتم حذف هذا المقطع القرآني من المجلس نهائياً.
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button @click="confirmDeleteOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300">
                        إلغاء
                    </button>
                    <button @click="$wire.delete(deleteId); confirmDeleteOpen = false" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                        نعم، احذف
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
