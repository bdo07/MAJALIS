<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Majlis;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use App\Models\TadabburLike;
use Illuminate\Support\Facades\Auth;

class MajlisShow extends Component
{
    public Majlis $majlis;
    public string $activeTab = 'tadabburat'; // 'tadabburat', 'hidayat', 'contribute'
    public string $contributionType = 'tadabbur'; // 'tadabbur' or 'hidayah'

    public string $content = '';
    public string $newHidayatContent = '';

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

    public function render()
    {
        return view('livewire.majlis-show');
    }
}
