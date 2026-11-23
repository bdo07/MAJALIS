<div class="py-10" dir="rtl" x-data="{ confirmDeleteOpen: false, deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Admin Dashboard Sub-Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100/70 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>لوحة إدارة المشرف</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 dark:text-white">
                    إدارة المجالس القرآنية
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                    إنشاء وتعديل ومتابعة مجالس القرآن الكريم وإدارة محتواها وحالة نشرها للعامة
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tadabburat.pending') }}" 
                   class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition flex items-center gap-2">
                    <span>⚖️</span>
                    <span>مراجعة التدبرات المعلقة</span>
                </a>

                <button wire:click="create" 
                        class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold text-xs rounded-xl shadow-sm shadow-emerald-600/30 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>إضافة مجلس جديد</span>
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

        <!-- Table Container -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            
            <!-- Table Header Toolbar -->
            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="w-full sm:w-80 relative">
                    <input wire:model.live.debounce.300ms="search" 
                           type="search" 
                           class="w-full pr-10 pl-4 py-2 text-xs bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-gray-900 dark:text-gray-100 placeholder-gray-400" 
                           placeholder="بحث في أسماء المجالس وأوصافها...">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="text-xs text-gray-500 dark:text-gray-400">
                    إجمالي المجالس: <strong class="text-gray-800 dark:text-gray-200 font-mono">{{ $majalis->total() }}</strong>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50/70 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3.5">عنوان المجلس</th>
                            <th class="px-6 py-3.5">المحتوى والآيات</th>
                            <th class="px-6 py-3.5">حالة النشر</th>
                            <th class="px-6 py-3.5">المشرف</th>
                            <th class="px-6 py-3.5">تاريخ الإضافة</th>
                            <th class="px-6 py-3.5 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($majalis as $majlis)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition">
                                <!-- Title & Slug -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white text-sm">
                                        {{ $majlis->title }}
                                    </div>
                                    <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-mono mt-0.5">
                                        #{{ $majlis->slug }}
                                    </div>
                                </td>

                                <!-- Counts -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.majalis.ayat', $majlis) }}" 
                                           class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-medium hover:bg-emerald-100 transition"
                                           title="اضغط لإدارة آيات هذا المجلس">
                                            📖 {{ $majlis->ayat_count }} مقطع
                                        </a>
                                        <span class="text-gray-400">•</span>
                                        <span>💡 {{ $majlis->tadabburat_count }}</span>
                                    </div>
                                </td>

                                <!-- Publish Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="togglePublish({{ $majlis->id }})" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold transition {{ $majlis->is_published ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}"
                                            title="اضغط لتغيير حالة النشر">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $majlis->is_published ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        <span>{{ $majlis->is_published ? 'منشور للعامة' : 'مسودة مخفية' }}</span>
                                    </button>
                                </td>

                                <!-- User -->
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                    {{ $majlis->user->name ?? 'المشرف العام' }}
                                </td>

                                <!-- Created At -->
                                <td class="px-6 py-4 whitespace-nowrap text-gray-400 font-mono text-[11px]">
                                    {{ $majlis->created_at?->format('Y-m-d') }}
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        
                                        <!-- View Live -->
                                        <a href="{{ route('majalis.show', $majlis) }}" 
                                           target="_blank" 
                                           class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 rounded-lg transition" 
                                           title="معاينة في الموقع">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>

                                        <!-- Manage Ayat -->
                                        <a href="{{ route('admin.majalis.ayat', $majlis) }}" 
                                           class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 rounded-lg transition" 
                                           title="إدارة الآيات والمقاطع">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </a>

                                        <!-- Edit -->
                                        <button wire:click="edit({{ $majlis->id }})" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/40 rounded-lg transition" 
                                                title="تعديل بيانات المجلس">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <!-- Audit History -->
                                        <button wire:click="showHistory({{ $majlis->id }})" 
                                                class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/40 rounded-lg transition" 
                                                title="سجل التعديلات والتدقيق">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>

                                        <!-- Delete -->
                                        <button @click="confirmDeleteOpen = true; deleteId = {{ $majlis->id }}" 
                                                class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition" 
                                                title="حذف المجلس">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-500">
                                    لم يتم العثور على أي مجالس مطابقة.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 dark:border-gray-800">
                {{ $majalis->links() }}
            </div>
        </div>

        <!-- Create / Edit Modal -->
        @if($isOpen)
            <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm animate-fade-in">
                <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-gray-800 space-y-6">
                    
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <h3 class="text-lg font-bold font-serif text-gray-900 dark:text-white">
                            {{ $isEditMode ? 'تعديل المجلس القرآني' : 'إنشاء مجلس قرآني جديد' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            ✕
                        </button>
                    </div>

                    <form wire:submit="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4 text-xs sm:text-sm">
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">
                                عنوان المجلس:
                            </label>
                            <input wire:model="title" type="text" 
                                   class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-emerald-500 focus:border-emerald-500" 
                                   placeholder="مثال: مجلس سورة الفاتحة - آيات الاستفتاح">
                            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1">
                                وصف المجلس ومنهج المدارسة:
                            </label>
                            <textarea wire:model="description" rows="4" 
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-emerald-500 focus:border-emerald-500" 
                                      placeholder="اكتب نبذة عن المجلس ومحاوره التربوية والتدبرية..."></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <input wire:model="is_published" type="checkbox" id="is_published" 
                                   class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                            <label for="is_published" class="text-xs text-gray-700 dark:text-gray-300 font-medium">
                                نشر المجلس مباشرة للعامة في الصفحة الرئيسية
                            </label>
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-semibold text-xs hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                إلغاء
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                                {{ $isEditMode ? 'حفظ التعديلات' : 'إنشاء المجلس' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <!-- Audit History Modal -->
        @if($historyModalOpen)
            <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm animate-fade-in">
                <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-gray-800 space-y-6 max-h-[85vh] flex flex-col">
                    
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <div>
                            <h3 class="text-base font-bold font-serif text-gray-900 dark:text-white">
                                سجل التعديلات والتدقيق
                            </h3>
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-0.5 truncate max-w-sm">
                                {{ $selectedMajlisTitle }}
                            </p>
                        </div>
                        <button wire:click="closeHistoryModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            ✕
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto space-y-4 pr-1">
                        @forelse($selectedMajlisHistory as $item)
                            <div class="relative pr-6 border-r-2 border-emerald-500/40 pb-4 space-y-1 text-xs">
                                <span class="absolute -right-1.5 top-0 w-3 h-3 rounded-full bg-emerald-600 ring-4 ring-white dark:ring-gray-900"></span>
                                <div class="flex items-center justify-between text-gray-400">
                                    <span>بواسطة: <strong class="text-gray-800 dark:text-gray-200">{{ $item->user_name }}</strong></span>
                                    <span class="font-mono text-[10px]">{{ $item->created_at }}</span>
                                </div>
                                <div class="font-semibold text-emerald-700 dark:text-emerald-300">
                                    الإجراء: {{ $item->action }}
                                </div>
                                @if($item->new_content)
                                    <p class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                        {{ $item->new_content }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-8">
                                لا توجد سجلات تعديل لهذا المجلس بعد.
                            </p>
                        @endforelse
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                        <button wire:click="closeHistoryModal" 
                                class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-semibold">
                            إغلاق
                        </button>
                    </div>

                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal (Alpine) -->
        <div x-show="confirmDeleteOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-900 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 border border-gray-100 dark:border-gray-800">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-950 text-red-600 flex items-center justify-center text-xl">
                    ⚠️
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white text-base">هل أنت متأكد من حذف هذا المجلس؟</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    سيؤدي ذلك إلى حذف جميع الآيات والتدبرات والهدايات المرتبطة به بصورة نهائية.
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
