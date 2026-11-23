<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Majlis;
use App\Models\Bookmark;
use Livewire\Livewire;
use App\Livewire\MajlisShow;
use App\Livewire\QuranShow;
use App\Livewire\MyContributions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_bookmarking_majlis(): void
    {
        $majlis = Majlis::create([
            'title' => 'مجلس الفاتحة التجريبي',
            'slug' => 'al-fatiha-test',
            'description' => 'توصيف مجلس الفاتحة',
            'is_published' => true,
        ]);

        Livewire::test(MajlisShow::class, ['majlis' => $majlis])
            ->call('toggleBookmark')
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_bookmark_and_unbookmark_majlis(): void
    {
        $user = User::factory()->create();
        $majlis = Majlis::create([
            'user_id' => $user->id,
            'title' => 'مجلس سورة الكهف',
            'slug' => 'al-kahf-test',
            'description' => 'توصيف مجلس الكهف',
            'is_published' => true,
        ]);

        $this->actingAs($user);

        // Bookmark
        Livewire::test(MajlisShow::class, ['majlis' => $majlis])
            ->call('toggleBookmark');

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'type' => 'majlis',
            'majlis_id' => $majlis->id,
        ]);

        // Unbookmark
        Livewire::test(MajlisShow::class, ['majlis' => $majlis])
            ->call('toggleBookmark');

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'type' => 'majlis',
            'majlis_id' => $majlis->id,
        ]);
    }

    public function test_authenticated_user_can_bookmark_surah_and_ayah(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Surah Bookmark
        Livewire::test(QuranShow::class, ['surah' => 1])
            ->call('toggleSurahBookmark');

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'type' => 'surah',
            'surah_number' => 1,
        ]);

        // Ayah Bookmark
        Livewire::test(QuranShow::class, ['surah' => 1])
            ->call('toggleAyahBookmark', 2, 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ');

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'type' => 'ayah',
            'surah_number' => 1,
            'ayah_number' => 2,
        ]);
    }

    public function test_user_can_view_and_delete_bookmarks_in_my_contributions(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $bookmark = Bookmark::create([
            'user_id' => $user->id,
            'type' => 'surah',
            'surah_number' => 18,
            'title' => 'سُورَةُ الكَهْفِ',
            'subtitle' => '110 آية • مكية',
        ]);

        Livewire::test(MyContributions::class)
            ->call('switchTab', 'bookmarks')
            ->assertSee('سُورَةُ الكَهْفِ')
            ->call('deleteBookmark', $bookmark->id);

        $this->assertDatabaseMissing('bookmarks', [
            'id' => $bookmark->id,
        ]);
    }
}
