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
     * Get high-quality MP3 recitation URL for the entire Surah.
     * Reciter: Sheikh Mishary Rashid Alafasy
     */
    public function getSurahAudioUrl(int $surahNumber): string
    {
        $padded = str_pad((string)$surahNumber, 3, '0', STR_PAD_LEFT);
        return "https://download.quranicaudio.com/quran/mishaari_raashid_al_3afaasee/{$padded}.mp3";
    }

    /**
     * Clean Surah name for search / display (removes 'سُورَةُ ' prefix if needed).
     */
    public function cleanSurahName(string $name): string
    {
        return trim(str_replace(['سُورَةُ', 'سورة', 'ٱ', 'ِ', 'ُ', 'َ', 'ّ', 'ْ', 'ً', 'ٍ', 'ٌ'], ['', '', 'ا', '', '', '', '', '', '', '', ''], $name));
    }
}
