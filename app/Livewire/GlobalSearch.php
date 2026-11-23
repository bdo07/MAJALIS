<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuranService;
use App\Models\Majlis;

class GlobalSearch extends Component
{
    public function render(QuranService $quranService)
    {
        $surahs = collect($quranService->getAllSurahs())->map(function ($s) {
            return [
                'type' => 'surah',
                'number' => $s['number'],
                'name' => $s['name'],
                'cleanName' => preg_replace('/[^\p{Arabic}\s]/u', '', $s['name']),
                'englishName' => $s['englishName'],
                'ayahs' => $s['numberOfAyahs'],
                'revelation' => ($s['revelationType'] ?? '') === 'Meccan' ? 'مكية' : 'مدنية',
                'url' => route('quran.show', $s['number']),
            ];
        });

        $majalis = Majlis::where('is_published', true)->get()->map(function ($m) {
            return [
                'type' => 'majlis',
                'title' => $m->title,
                'description' => \Illuminate\Support\Str::limit(strip_tags($m->description ?? ''), 90),
                'url' => route('majalis.show', $m),
            ];
        });

        return view('livewire.global-search', [
            'searchData' => [
                'surahs' => $surahs,
                'majalis' => $majalis,
            ]
        ]);
    }
}
