<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuranService
{
    protected string $storagePath;

    public function __construct()
    {
        $this->storagePath = storage_path('app/quran');
        if (!File::exists($this->storagePath)) {
            File::makeDirectory($this->storagePath, 0755, true);
        }
    }

    /**
     * Get the full index list of all 114 Surahs.
     */
    public function getAllSurahs(): array
    {
        $filePath = $this->storagePath . '/surahs.json';

        if (File::exists($filePath)) {
            $json = json_decode(File::get($filePath), true);
            return $json['data'] ?? [];
        }

        try {
            $response = Http::timeout(10)->get('https://api.alquran.cloud/v1/surah');
            if ($response->successful()) {
                File::put($filePath, $response->body());
                return $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            Log::error('QuranService getAllSurahs error: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get a specific Surah with full verified Uthmani verses.
     */
    public function getSurah(int $surahNumber): ?array
    {
        if ($surahNumber < 1 || $surahNumber > 114) {
            return null;
        }

        $filePath = $this->storagePath . "/surah_{$surahNumber}.json";

        if (File::exists($filePath)) {
            $json = json_decode(File::get($filePath), true);
            return $json['data'] ?? null;
        }

        try {
            $response = Http::timeout(15)->get("https://api.alquran.cloud/v1/surah/{$surahNumber}/quran-uthmani");
            if ($response->successful()) {
                File::put($filePath, $response->body());
                return $response->json('data') ?? null;
            }
        } catch (\Exception $e) {
            Log::error("QuranService getSurah({$surahNumber}) error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get classical Tafsir Al-Muyassar for a Surah.
     * Returns an associative array [ayah_number => tafsir_text].
     */
    public function getSurahTafsir(int $surahNumber): array
    {
        if ($surahNumber < 1 || $surahNumber > 114) {
            return [];
        }

        $filePath = $this->storagePath . "/tafsir_{$surahNumber}.json";

        if (File::exists($filePath)) {
            $json = json_decode(File::get($filePath), true);
            $ayahs = $json['data']['ayahs'] ?? [];
            $mapped = [];
            foreach ($ayahs as $a) {
                $mapped[$a['numberInSurah']] = $a['text'];
            }
            return $mapped;
        }

        try {
            $response = Http::timeout(15)->get("https://api.alquran.cloud/v1/surah/{$surahNumber}/ar.muyassar");
            if ($response->successful()) {
                File::put($filePath, $response->body());
                $data = $response->json('data');
                $ayahs = $data['ayahs'] ?? [];
                $mapped = [];
                foreach ($ayahs as $a) {
                    $mapped[$a['numberInSurah']] = $a['text'];
                }
                return $mapped;
            }
        } catch (\Exception $e) {
            Log::error("QuranService getSurahTafsir({$surahNumber}) error: " . $e->getMessage());
        }

        return [];
    }

    /**
     * Get previous and next Surah numbers for navigation.
     */
    public function getSurahNeighbors(int $surahNumber): array
    {
        return [
            'prev' => $surahNumber > 1 ? $surahNumber - 1 : null,
            'next' => $surahNumber < 114 ? $surahNumber + 1 : null,
        ];
    }

    /**
     * Available trusted reciters.
     */
    public function getAvailableReciters(): array
    {
        return [
            'ar.alafasy' => [
                'name' => 'مشاري راشد العفاسي',
                'sub' => 'حفص عن عاصم',
            ],
            'ar.husary' => [
                'name' => 'محمود خليل الحصري',
                'sub' => 'المصحف المرتل',
            ],
        ];
    }

    /**
     * Get high-quality MP3 recitation URL for the entire Surah.
     */
    public function getSurahAudioUrl(int $surahNumber, string $reciter = 'ar.alafasy'): string
    {
        if ($reciter === 'ar.husary') {
            $padded = str_pad((string)$surahNumber, 3, '0', STR_PAD_LEFT);
            return "https://cdn.mp3quran.net/audio/mahmoud-husary/r1/{$padded}.mp3";
        }

        return "https://cdn.islamic.network/quran/audio-surah/128/ar.alafasy/{$surahNumber}.mp3";
    }

    /**
     * Clean Surah name for search and comparison.
     */
    public function cleanSurahName(string $name): string
    {
        return trim(str_replace(['سُورَةُ', 'سورة', 'ٱ', 'ِ', 'ُ', 'َ', 'ّ', 'ْ', 'ً', 'ٍ', 'ٌ'], ['', '', 'ا', '', '', '', '', '', '', '', ''], $name));
    }

    /**
     * Find Surah number by Arabic or clean name.
     */
    public function getSurahNumberByName(string $surahName): ?int
    {
        $cleanSearch = $this->cleanSurahName($surahName);
        foreach ($this->getAllSurahs() as $s) {
            if ($this->cleanSurahName($s['name']) === $cleanSearch) {
                return (int)$s['number'];
            }
        }
        return null;
    }
}
