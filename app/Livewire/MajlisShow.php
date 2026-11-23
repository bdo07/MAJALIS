<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Majlis;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use App\Models\TadabburLike;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class MajlisShow extends Component
{
    public Majlis $majlis;
    public string $activeTab = 'tadabburat'; // 'tadabburat', 'hidayat', 'contribute'
    public string $contributionType = 'tadabbur'; // 'tadabbur' or 'hidayah'

    public string $content = '';
    public string $newHidayatContent = '';
    public bool $showTafsir = false;

    public function toggleBookmark()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existing = Bookmark::where('user_id', Auth::id())
            ->where('type', 'majlis')
            ->where('majlis_id', $this->majlis->id)
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('bookmark_message', 'تمت إزالة المجلس من محفوظاتك.');
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'type' => 'majlis',
                'majlis_id' => $this->majlis->id,
                'title' => $this->majlis->title,
                'subtitle' => 'مجلس مدارسة وتدبر قرآني',
            ]);
            session()->flash('bookmark_message', 'تم حفظ المجلس في محفوظاتك المرجعية.');
        }
    }

    public function getIsBookmarkedProperty(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        return Bookmark::where('user_id', Auth::id())
            ->where('type', 'majlis')
            ->where('majlis_id', $this->majlis->id)
            ->exists();
    }

    public function toggleTafsir()
    {
        $this->showTafsir = !$this->showTafsir;
    }

    protected function rules()
    {
        return [
            'content' => 'required|min:10|max:1500',
        ];
    }

    public function mount(Majlis $majlis)
    {
        $this->majlis = $majlis->load([
            'ayat',
            'user',
            'tadabburat' => fn($q) => $q->where('status', 'approved')->with(['user', 'likes'])->latest(),
            'hidayat' => fn($q) => $q->where('status', 'approved')->with('user')->latest(),
        ]);
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function setContributionType(string $type)
    {
        $this->contributionType = $type;
    }

    public function storeTadabbur()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Tadabbur::create([
            'user_id' => Auth::id(),
            'majlis_id' => $this->majlis->id,
            'content' => $this->content,
            'status' => 'pending',
            'likes_count' => 0,
        ]);

        $this->content = '';

        session()->flash('message', 'جزاك الله خيراً! تم إرسال تدبرك الإيماني وسيظهر للجميع فور اعتماده من المشرف.');

        $this->mount($this->majlis->refresh());
    }

    public function toggleLike(int $tadabburId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $tadabbur = Tadabbur::findOrFail($tadabburId);

        $existingLike = TadabburLike::where('user_id', $userId)
            ->where('tadabbur_id', $tadabburId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $tadabbur->decrement('likes_count');
        } else {
            TadabburLike::create([
                'user_id' => $userId,
                'tadabbur_id' => $tadabburId,
            ]);
            $tadabbur->increment('likes_count');
        }

        $this->mount($this->majlis->refresh());
    }

    public function storeHidayat()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'newHidayatContent' => 'required|min:10|max:1500',
        ]);

        Hidayah::create([
            'user_id' => Auth::id(),
            'majlis_id' => $this->majlis->id,
            'content' => $this->newHidayatContent,
            'status' => 'pending',
            'votes_count' => 0,
        ]);

        $this->newHidayatContent = '';

        session()->flash('hidayat_message', 'بارك الله فيك! تم إرسال الهداية العملية وسيتم نشرها بعد مراجعة المشرف.');

        $this->mount($this->majlis->refresh());
    }

    public function upvoteHidayah(int $hidayahId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $hidayah = Hidayah::findOrFail($hidayahId);
        $hidayah->increment('votes_count');

        session()->flash('hidayat_vote_message_' . $hidayahId, 'شكر الله لك! تم تسجيل تأييدك للعمل بهذه الهداية.');

        $this->mount($this->majlis->refresh());
    }

    public function render(\App\Services\QuranService $quranService)
    {
        $tafsirMap = [];
        if ($this->showTafsir) {
            foreach ($this->majlis->ayat as $ayah) {
                $surahNum = $quranService->getSurahNumberByName($ayah->surah_name);
                if ($surahNum) {
                    $tafsir = $quranService->getSurahTafsir($surahNum);
                    for ($v = $ayah->from_ayah; $v <= $ayah->to_ayah; $v++) {
                        if (isset($tafsir[$v])) {
                            $tafsirMap[$ayah->id][$v] = $tafsir[$v];
                        }
                    }
                }
            }
        }

        return view('livewire.majlis-show', [
            'tafsirMap' => $tafsirMap,
        ]);
    }
}
