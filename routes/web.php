<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// User Livewire components
use App\Livewire\MajlisShow;
use App\Livewire\MajalisIndex;
use App\Livewire\MyContributions;
use App\Livewire\QuranIndex;
use App\Livewire\QuranShow;
// Admin Livewire components
use App\Livewire\Admin\TadabburModeration;
use App\Livewire\Admin\MajlisManager;
use App\Livewire\Admin\AyahManager;

// 1. الصفحة الرئيسية وتصفح المجالس القرآنية (بدون auth)
Route::get('/', MajalisIndex::class)->name('majalis.index');
Route::get('/majalis/{majlis}', MajlisShow::class)->name('majalis.show');

// 2. تصفح المصحف الشريف والسور الكريمة (بدون auth)
Route::get('/quran', QuranIndex::class)->name('quran.index');
Route::get('/quran/{surah}', QuranShow::class)->name('quran.show');

// 3. لوحة التحكم والمسارات الخاصة بالأعضاء والمشرفين
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', MajalisIndex::class)->name('dashboard'); // للإحالة المتوافقة
    Route::get('/my-contributions', MyContributions::class)->name('my-contributions');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. مسارات الإدارة والإشراف
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tadabburat/pending', TadabburModeration::class)->name('tadabburat.pending');
    Route::get('/majalis', MajlisManager::class)->name('majalis.index');
    Route::get('/majalis/{majlis}/ayat', AyahManager::class)->name('majalis.ayat');
});

require __DIR__ . '/auth.php';
