<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuranService;
use App\Models\Majlis;

class QuranShow extends Component
{
    public int $surahNumber;
    public string $viewMode = 'mushaf'; // 'mushaf' or 'verse_by_verse'
    public string $fontSize = 'normal'; // 'small', 'normal', 'large', 'xl'

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

    public function render(QuranService $quranService)
    {
        $surahData = $quranService->getSurah($this->surahNumber);

        if (!$surahData) {
            abort(500, 'تعذر تحميل بيانات السورة الكريمة.');
        }

        $neighbors = $quranService->getSurahNeighbors($this->surahNumber);
        $audioUrl = $quranService->getSurahAudioUrl($this->surahNumber);

        // البحث عما إذا كان هناك مجالس تدبرية مرتبطة بهذه السورة
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
            'neighbors' => $neighbors,
            'audioUrl' => $audioUrl,
            'relatedMajalis' => $relatedMajalis,
        ])->layout('layouts.app');
    }
}
