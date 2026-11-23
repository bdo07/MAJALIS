<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Majlis;
use Livewire\Livewire;
use App\Livewire\GlobalSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GlobalSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_global_search_mounts_and_contains_surahs_and_majalis(): void
    {
        $majlis = Majlis::create([
            'title' => 'مجلس سورة الملك للتدبر',
            'slug' => 'al-mulk-search-test',
            'description' => 'مدارسة عامة لسورة الملك',
            'is_published' => true,
        ]);

        $test = Livewire::test(GlobalSearch::class);
        $test->assertSee('ابحث عن سورة بالاسم أو الرقم، أو مجلس قرآني')
             ->assertSee('مجالس القرآن الكريم • 114 سورة');

        $viewData = $test->viewData('searchData');
        $this->assertNotEmpty($viewData['surahs']);
        $this->assertCount(114, $viewData['surahs']);
        $this->assertTrue(collect($viewData['majalis'])->contains('title', 'مجلس سورة الملك للتدبر'));
    }
}
