<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuranService;
use App\Models\Majlis;

class QuranIndex extends Component
{
    public string $search = '';
    public string $filter = 'all'; // 'all', 'Meccan', 'Medinan', 'juz_amma'

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    public function render(QuranService $quranService)
    {
        $allSurahs = $quranService->getAllSurahs();

        // تصفية السور
        $filteredSurahs = array_filter($allSurahs, function ($surah) use ($quranService) {
            // تصفية حسب النوع
            if ($this->filter === 'Meccan' && ($surah['revelationType'] ?? '') !== 'Meccan') {
                return false;
            }
            if ($this->filter === 'Medinan' && ($surah['revelationType'] ?? '') !== 'Medinan') {
                return false;
            }
            if ($this->filter === 'juz_amma' && ($surah['number'] ?? 0) < 78) {
                return false;
            }

            // بحث بالاسم أو الرقم
            if (!empty($this->search)) {
                $term = trim($this->search);
                $cleanedName = $quranService->cleanSurahName($surah['name'] ?? '');
                $cleanedTerm = $quranService->cleanSurahName($term);

                $matchNumber = (string)($surah['number'] ?? '') === $term;
                $matchName = str_contains($cleanedName, $cleanedTerm) || str_contains($surah['name'] ?? '', $term);
                $matchEnglish = stripos($surah['englishName'] ?? '', $term) !== false || stripos($surah['englishNameTranslation'] ?? '', $term) !== false;

                return $matchNumber || $matchName || $matchEnglish;
            }

            return true;
        });

        // خريطة المجالس المتاحة لربطها بالسور
        $majalisSurahs = Majlis::where('is_published', true)
            ->whereHas('ayat')
            ->with('ayat')
            ->get()
            ->pluck('ayat.*.surah_name')
            ->flatten()
            ->unique()
            ->toArray();

        return view('livewire.quran-index', [
            'surahs' => $filteredSurahs,
            'totalSurahs' => count($allSurahs),
            'majalisSurahs' => $majalisSurahs,
        ])->layout('layouts.app');
    }
}
