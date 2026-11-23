<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuranService;
use App\Models\Majlis;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class QuranShow extends Component
{
    public int $surahNumber;
    public string $viewMode = 'verse_by_verse'; // 'verse_by_verse', 'mushaf'
    public string $fontSize = 'normal'; // 'small', 'normal', 'large', 'xl'
    public string $reciter = 'ar.alafasy';
    public bool $showTafsir = false;

    public function mount(int $surah)
    {
        if ($surah < 1 || $surah > 114) {
            abort(404, 'رقم السورة غير صحيح.');
        }
        $this->surahNumber = $surah;
    }

    public function setViewMode(string $mode)
    {
        $this->viewMode = $mode;
    }

    public function setFontSize(string $size)
    {
        $this->fontSize = $size;
    }

    public function setReciter(string $reciterKey)
    {
        $this->reciter = $reciterKey;
    }

    public function toggleTafsir()
    {
        $this->showTafsir = !$this->showTafsir;
    }

    public function toggleSurahBookmark()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existing = Bookmark::where('user_id', Auth::id())
            ->where('type', 'surah')
            ->where('surah_number', $this->surahNumber)
            ->whereNull('ayah_number')
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('bookmark_message', 'تمت إزالة السورة من محفوظاتك.');
        } else {
            $surahData = app(QuranService::class)->getSurah($this->surahNumber);
            Bookmark::create([
                'user_id' => Auth::id(),
                'type' => 'surah',
                'surah_number' => $this->surahNumber,
                'title' => $surahData['name'] ?? ('سورة رقم ' . $this->surahNumber),
                'subtitle' => ($surahData['numberOfAyahs'] ?? 0) . ' آية • ' . (($surahData['revelationType'] ?? '') === 'Meccan' ? 'مكية' : 'مدنية'),
            ]);
            session()->flash('bookmark_message', 'تم حفظ السورة في محفوظاتك المرجعية.');
        }
    }

    public function toggleAyahBookmark(int $ayahNumber, string $verseText)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existing = Bookmark::where('user_id', Auth::id())
            ->where('type', 'ayah')
            ->where('surah_number', $this->surahNumber)
            ->where('ayah_number', $ayahNumber)
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('bookmark_message', "تمت إزالة الآية ({$ayahNumber}) من محفوظاتك.");
        } else {
            $surahData = app(QuranService::class)->getSurah($this->surahNumber);
            $cleanSurah = app(QuranService::class)->cleanSurahName($surahData['name'] ?? '');
            Bookmark::create([
                'user_id' => Auth::id(),
                'type' => 'ayah',
                'surah_number' => $this->surahNumber,
                'ayah_number' => $ayahNumber,
                'title' => "سورة {$cleanSurah} - آية {$ayahNumber}",
                'subtitle' => \Illuminate\Support\Str::limit($verseText, 90),
            ]);
            session()->flash('bookmark_message', "تم حفظ الآية ({$ayahNumber}) في محفوظاتك المرجعية.");
        }
    }

    public function getBookmarkedAyahsProperty(): array
    {
        if (!Auth::check()) {
            return [];
        }
        return Bookmark::where('user_id', Auth::id())
            ->where('type', 'ayah')
            ->where('surah_number', $this->surahNumber)
            ->pluck('ayah_number')
            ->toArray();
    }

    public function getIsSurahBookmarkedProperty(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        return Bookmark::where('user_id', Auth::id())
            ->where('type', 'surah')
            ->where('surah_number', $this->surahNumber)
            ->whereNull('ayah_number')
            ->exists();
    }

    public function render(QuranService $quranService)
    {
        $surahData = $quranService->getSurah($this->surahNumber);

        if (!$surahData) {
            abort(500, 'تعذر تحميل بيانات السورة الكريمة.');
        }

        $tafsirMap = $this->showTafsir ? $quranService->getSurahTafsir($this->surahNumber) : [];
        $neighbors = $quranService->getSurahNeighbors($this->surahNumber);
        $audioUrl = $quranService->getSurahAudioUrl($this->surahNumber, $this->reciter);
        $reciters = $quranService->getAvailableReciters();

        // ربط السورة بمجالس التدبر النشطة
        $cleanName = $quranService->cleanSurahName($surahData['name'] ?? '');
        $relatedMajalis = Majlis::where('is_published', true)
            ->where(function ($q) use ($cleanName) {
                $q->where('title', 'like', '%' . $cleanName . '%')
                  ->orWhereHas('ayat', function ($aq) use ($cleanName) {
                      $aq->where('surah_name', 'like', '%' . $cleanName . '%');
                  });
            })
            ->withCount(['ayat', 'tadabburat', 'hidayat'])
            ->get();

        return view('livewire.quran-show', [
            'surah' => $surahData,
            'tafsirMap' => $tafsirMap,
            'neighbors' => $neighbors,
            'audioUrl' => $audioUrl,
            'reciters' => $reciters,
            'relatedMajalis' => $relatedMajalis,
        ])->layout('layouts.app');
    }
}
