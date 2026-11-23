<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use App\Models\Bookmark;

class MyContributions extends Component
{
    use WithPagination;

    public $tab = 'tadabburat'; // tadabburat, hidayat, bookmarks
    public $bookmarkType = 'all'; // all, majlis, surah, ayah

    public function switchTab($tabName)
    {
        $this->tab = $tabName;
        $this->resetPage();
    }

    public function setBookmarkFilter($type)
    {
        $this->bookmarkType = $type;
        $this->resetPage('bookmarkPage');
    }

    public function deleteTadabbur($id)
    {
        $tadabbur = Tadabbur::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $tadabbur->delete();
        session()->flash('message', 'تم حذف التدبر بنجاح.');
    }

    public function deleteHidayah($id)
    {
        $hidayah = Hidayah::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $hidayah->delete();
        session()->flash('message', 'تم حذف الهداية بنجاح.');
    }

    public function deleteBookmark($id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $bookmark->delete();
        session()->flash('message', 'تمت إزالة العلامة المرجعية بنجاح.');
    }

    public function render()
    {
        $tadabburat = Tadabbur::where('user_id', auth()->id())
            ->with('majlis')
            ->latest()
            ->paginate(5, ['*'], 'tadabburPage');

        $hidayat = Hidayah::where('user_id', auth()->id())
            ->with('majlis')
            ->latest()
            ->paginate(5, ['*'], 'hidayatPage');

        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('majlis')
            ->when($this->bookmarkType !== 'all', fn ($query) => $query->where('type', $this->bookmarkType))
            ->latest()
            ->paginate(6, ['*'], 'bookmarkPage');

        return view('livewire.my-contributions', [
            'tadabburat' => $tadabburat,
            'hidayat' => $hidayat,
            'bookmarks' => $bookmarks,
        ])->layout('layouts.app');
    }
}
