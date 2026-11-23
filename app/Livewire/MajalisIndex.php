<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Majlis;
use App\Models\Ayah;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use Livewire\WithPagination;

class MajalisIndex extends Component
{
    use WithPagination;

    // المتغير الذي سيرتبط بحقل البحث
    public $search = '';

    // تصفية حسب التصنيف / الترتيب
    public $sortBy = 'latest'; // latest, popular

    // تصفية حسب السورة
    public $surah = '';

    // تصفير أرقام الصفحات عند تغيير البحث أو التصفية
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingSurah()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->surah = '';
        $this->sortBy = 'latest';
        $this->resetPage();
    }

    public function render()
    {
        $query = Majlis::where('is_published', true)
            ->withCount([
                'ayat',
                'tadabburat' => fn($q) => $q->where('status', 'approved'),
                'hidayat' => fn($q) => $q->where('status', 'approved')
            ])
            ->when($this->search, function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('ayat', function ($ayahQuery) {
                            $ayahQuery->where('surah_name', 'like', '%' . $this->search . '%')
                                     ->orWhere('quranic_text', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->surah, function ($q) {
                $q->whereHas('ayat', function ($ayahQuery) {
                    $ayahQuery->where('surah_name', $this->surah);
                });
            });

        if ($this->sortBy === 'popular') {
            $query->orderByDesc('tadabburat_count');
        } else {
            $query->latest();
        }

        $majalis = $query->paginate(9);

        // قائمة السور المتاحة في المجالس للتصفية السريعة
        $availableSurahs = Ayah::distinct()->pluck('surah_name');

        // إحصائيات عامة للمنصة
        $stats = [
            'majalis_count' => Majlis::where('is_published', true)->count(),
            'ayat_count' => Ayah::count(),
            'tadabburat_count' => Tadabbur::where('status', 'approved')->count(),
            'hidayat_count' => Hidayah::where('status', 'approved')->count(),
        ];

        return view('livewire.majlis-index', [
            'majalis' => $majalis,
            'availableSurahs' => $availableSurahs,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}
