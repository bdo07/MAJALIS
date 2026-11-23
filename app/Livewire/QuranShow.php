<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuranService;
use App\Models\Majlis;

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
