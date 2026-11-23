<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuranTest extends TestCase
{
    use RefreshDatabase;

    public function test_quran_index_page_is_accessible(): void
    {
        $response = $this->get('/quran');
        $response->assertStatus(200);
        $response->assertSee('المصحف الشريف');
    }

    public function test_quran_show_surah_page_is_accessible(): void
    {
        // Surah 1 Al-Fatiha
        $response = $this->get('/quran/1');
        $response->assertStatus(200);
        $response->assertSee('سُورَةُ ٱلْفَاتِحَةِ');
    }

    public function test_quran_surah_invalid_number_returns_404(): void
    {
        $response = $this->get('/quran/999');
        $response->assertStatus(404);
    }
}
