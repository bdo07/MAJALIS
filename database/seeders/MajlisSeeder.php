<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Majlis;
use App\Models\Ayah;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use App\Models\TadabburLike;
use Spatie\Permission\Models\Role;

class MajlisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // 2. مستخدم مشرف النظام
        $admin = User::firstOrCreate([
            'email' => 'admin@majalis.test'
        ], [
            'name' => 'المشرف العام',
            'password' => bcrypt('password')
        ]);
        $admin->syncRoles([$adminRole]);

        // 3. مستخدم قارئ متدبر
        $reader = User::firstOrCreate([
            'email' => 'reader@majalis.test'
        ], [
            'name' => 'قارئ متدبر',
            'password' => bcrypt('password')
        ]);
        $reader->syncRoles([$userRole]);

        // ==========================================
        // المجلس الأول: سورة الفاتحة
        // ==========================================
        $majlis1 = Majlis::create([
            'user_id' => $admin->id,
            'title' => 'مجلس سورة الفاتحة - آيات الاستفتاح والتعبد',
            'slug' => 'al-fatiha',
            'description' => 'دراسة وتدبر لمعاني الفاتحة كما يقررها منهج الإمام الشيخ فريد الأنصاري رحمه الله، وفقه التحرر من عبودية الأغيار إلى عبودية الواحد القهار.',
            'is_published' => true,
        ]);

        Ayah::create([
            'majlis_id' => $majlis1->id,
            'surah_name' => 'الفاتحة',
            'from_ayah' => 1,
            'to_ayah' => 7,
            'quranic_text' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ (1) الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ (2) الرَّحْمَٰنِ الرَّحِيمِ (3) مَالِكِ يَوْمِ الدِّينِ (4) إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ (5) اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ (6) صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ (7)',
            'bayan_text' => 'البيان العام والتأسيس الإيماني: افتتاح السورة بالبسملة والحمد يعلمنا تعلق القلب بالله استحقاقاً ومحبة، وتفريد العبادة والاستعانة يحرر العبد من عبودية سوى الله، والدعاء بالهداية للصراط المستقيم يربط المسلم بقوافل الصالحين من النبيين والصديقين والشهداء.',
        ]);

        $t1 = Tadabbur::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis1->id,
            'content' => 'وقفة مع "إياك نعبد": تقديم المعمول (إياك) يفيد الحصر والاختصاص؛ فلا تعلق القلب بغيره، ولا ترجو سواه، ولا تخشى إلا منه سبحانه.',
            'status' => 'approved',
            'likes_count' => 12,
        ]);

        TadabburLike::firstOrCreate([
            'user_id' => $admin->id,
            'tadabbur_id' => $t1->id,
        ]);

        Tadabbur::create([
            'user_id' => $admin->id,
            'majlis_id' => $majlis1->id,
            'content' => 'في قوله "رب العالمين" أمان نفسي عظيم؛ فمن كان ربه رب العوالم كلها لم يقلق على رزق ولا مستقبل.',
            'status' => 'approved',
            'likes_count' => 8,
        ]);

        Hidayah::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis1->id,
            'content' => 'تجديد العهد مع الله في كل صلاة بأن تكون الاستعانة خالصة له وحده في كل شؤون اليوم، والتوكل عليه في الأزمات والرخاء.',
            'status' => 'approved',
            'votes_count' => 7,
        ]);

        // ==========================================
        // المجلس الثاني: سورة الإخلاص
        // ==========================================
        $majlis2 = Majlis::create([
            'user_id' => $admin->id,
            'title' => 'مجلس سورة الإخلاص - تجريد التوحيد لله',
            'slug' => 'al-ikhlas',
            'description' => 'بيان معنى الأحدية والصَمَدانية لله عز وجل، وتحرير باطن النفس من الشرك الخفي ورجاء المخلوقين.',
            'is_published' => true,
        ]);

        Ayah::create([
            'majlis_id' => $majlis2->id,
            'surah_name' => 'الإخلاص',
            'from_ayah' => 1,
            'to_ayah' => 4,
            'quranic_text' => 'قُلْ هُوَ اللَّهُ أَحَدٌ (1) اللَّهُ الصَّمَدُ (2) لَمْ يَلِدْ وَلَمْ يُولَدْ (3) وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ (4)',
            'bayan_text' => 'البيان العام: السورة تقرر أصل التوحيد الخالص لله تعالى، وأنه الصمد الذي تصمد إليه الخلائق كلها في حوائجها، وتنقض كل أشكال الشرك والارتباط العبدي بغيره.',
        ]);

        Tadabbur::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis2->id,
            'content' => 'معية "الصمد": حين تعلم أن الله هو الصمد وحده الذي تُقصد الحاجات إليه، ترتاح النفس من الذل للمخلوقين وترتفع عزة المؤمن بالله.',
            'status' => 'approved',
            'likes_count' => 15,
        ]);

        Hidayah::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis2->id,
            'content' => 'الاعتماد القلبي على الله وحده في قضاء الحوائج، وتدبر معاني الأحدية والصمدانية في أذكار الصباح والمساء.',
            'status' => 'approved',
            'votes_count' => 9,
        ]);

        // ==========================================
        // المجلس الثالث: سورة الكهف
        // ==========================================
        $majlis3 = Majlis::create([
            'user_id' => $admin->id,
            'title' => 'مجلس سورة الكهف - عصمة الفتن وبصائر الهداية',
            'slug' => 'al-kahf',
            'description' => 'تأملات في سفينة النجاة من فتن الزمان: فتنة الدين، والمال، والعلم، والسلطان، وفقه الصبر والملازمة مع الصالحين.',
            'is_published' => true,
        ]);

        Ayah::create([
            'majlis_id' => $majlis3->id,
            'surah_name' => 'الكهف',
            'from_ayah' => 28,
            'to_ayah' => 28,
            'quranic_text' => 'وَاصْبِرْ نَفْسَكَ مَعَ الَّذِينَ يَدْعُونَ رَبَّهُم بِالْغَدَاةِ وَالْعَشِيِّ يُرِيدُونَ وَجْهَهُ وَلَا تَعْدُ عَيْنَاكَ عَنْهُمْ تُرِيدُ زِينَةَ الْحَيَاةِ الدُّنْيَا وَلَا تُطِعْ مَنْ أَغْفَلْنَا قَلْبَهُ عَن ذِكْرِنَا وَاتَّبَعَ هَوَاهُ وَكَانَ أَمْرُهُ فُرُطًا (28)',
            'bayan_text' => 'البيان العام: أمر الله لنبيه صلى الله عليه وسلم ولمن تبعه بحبس النفس ولزوم صحبة الذاكرين المخلصين، والتحذير من الانجذاب لزخارف الدنيا والانسياق خلف الغافلين.',
        ]);

        Tadabbur::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis3->id,
            'content' => 'الصبر مع الصالحين ليس سهلاً، ولذلك قال تعالى "واصبر نفسك"، فالنفس قد تميل إلى العزلة أو أصحاب الدنيا، ولكن النجاة في الرفقة الصالحة.',
            'status' => 'approved',
            'likes_count' => 21,
        ]);

        Hidayah::create([
            'user_id' => $admin->id,
            'majlis_id' => $majlis3->id,
            'content' => 'اختيار بيئة إيمانية صالحة ومجالسة أهل القرآن والذكر، والابتعاد عن مجالس اللغو ومتابعة أهل الغفلة على منصات التواصل.',
            'status' => 'approved',
            'votes_count' => 14,
        ]);

        // تدبرات وهدايات قيد المراجعة لاختبار لوحة المشرف
        Tadabbur::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis1->id,
            'content' => 'الاستعانة بالله في سورة الفاتحة تسبق طلب الهداية، لأن الهداية ذاتها لا تُنال إلا بإعانة الله وتوفيقه.',
            'status' => 'pending',
            'likes_count' => 0,
        ]);

        Hidayah::create([
            'user_id' => $reader->id,
            'majlis_id' => $majlis3->id,
            'content' => 'تخصيص وقت يومي لقراءة سورة الكهف والجلوس مع الذاكرين بعد صلاة الفجر أو العصر.',
            'status' => 'pending',
            'votes_count' => 0,
        ]);
    }
}
