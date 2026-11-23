<footer class="mt-20 border-t border-gray-200/70 dark:border-gray-800/80 bg-white/60 dark:bg-gray-900/60 backdrop-blur-md" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <!-- Col 1: Platform Brand & Mission -->
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-emerald-700 text-white rounded-xl shadow-md shadow-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold font-serif text-gray-900 dark:text-white tracking-wide">
                            مجالس القرآن الكريم
                        </span>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">منهج التلقي والتزكية والبلاغ</p>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed max-w-lg">
                    منصة قرآنية تفاعلية تسعى لإحياء سنة تدبر كتاب الله ومدارسته، مستندة إلى منهجية الإمام المربي الدكتور فريد الأنصاري رحمه الله، للانتقال بالآيات من مجرد التلاوة إلى فقه العمل والتزكية.
                </p>

                <div class="p-4 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-800/40 text-xs text-emerald-900 dark:text-emerald-200">
                    <span class="font-serif text-sm block mb-1 font-bold text-emerald-700 dark:text-emerald-300">﴿كِتَابٌ أَنزَلْنَاهُ إِلَيْكَ مُبَارَكٌ لِّيَدَّبَّرُوا آيَاتِهِ وَلِيَتَذَكَّرَ أُولُو الْأَلْبَابِ﴾</span>
                    <span class="text-gray-500 dark:text-gray-400 font-sans">[سورة ص: 29]</span>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white font-serif">روابط المنصة</h4>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li>
                        <a href="{{ route('majalis.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                            <span>📖</span>
                            <span>تصفح المجالس</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                            <span>🕌</span>
                            <span>المصحف الشريف (114 سورة)</span>
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('my-contributions') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                                <span>✍️</span>
                                <span>مساهماتي وتدبراتي</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                                <span>👤</span>
                                <span>الملف الشخصي</span>
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route('admin.majalis.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                                    <span>⚙️</span>
                                    <span>لوحة إدارة المجالس</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                                <span>🔐</span>
                                <span>تسجيل الدخول</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                                <span>✨</span>
                                <span>انضمام للمنصة</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Col 3: Principles / Methodology -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white font-serif">أركان المجلس القرآني</h4>
                <ul class="space-y-2.5 text-xs text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">١.</span>
                        <div>
                            <span class="font-semibold text-gray-800 dark:text-gray-200 block">التلاوة والبيان:</span>
                            <span>استحضار الآيات وفهم البيان العام والتأسيس الإيماني لها.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">٢.</span>
                        <div>
                            <span class="font-semibold text-gray-800 dark:text-gray-200 block">التدبر والتزكية:</span>
                            <span>استخراج اللطائف الإيمانية وتطهير القلب بمعاني الوحي.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">٣.</span>
                        <div>
                            <span class="font-semibold text-gray-800 dark:text-gray-200 block">الهدايات والعمل:</span>
                            <span>تحويل التدبر إلى سلوك يومي وخلق حي ينبض بالقرآن.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 dark:text-gray-400">
            <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} — منصة مجالس القرآن الكريم</p>
            <div class="flex items-center gap-4">
                <span>تدارس كتاب الله في مجالس العلم والإيمان</span>
                <span class="text-emerald-600 dark:text-emerald-400">●</span>
                <span>رحم الله الشيخ فريد الأنصاري</span>
            </div>
        </div>
    </div>
</footer>
