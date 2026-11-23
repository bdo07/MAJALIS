<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use Livewire\WithPagination;

class TadabburModeration extends Component
{
    use WithPagination;

    public string $activeTab = 'tadabburat'; // 'tadabburat', 'hidayat', 'approved'

    public function boot()
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة المراجعة.');
        }
    }

    public function switchTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // الموافقة على التدبر
    public function approve($id)
    {
        $tadabbur = Tadabbur::findOrFail($id);
        $tadabbur->update(['status' => 'approved']);

        session()->flash('message', 'تم اعتماد التدبر بنجاح ونشره للعامة في المجلس.');
    }

    // رفض وحذف التدبر
    public function reject($id)
    {
        $tadabbur = Tadabbur::findOrFail($id);
        $tadabbur->delete();

        session()->flash('error', 'تم رفض وحذف التدبر.');
    }

    // الموافقة على الهداية
    public function approveHidayah($id)
    {
        Hidayah::findOrFail($id)->update(['status' => 'approved']);
        session()->flash('message', 'تمت الموافقة على الهداية ونشرها بنجاح.');
    }

    // رفض وحذف الهداية
    public function rejectHidayah($id)
    {
        Hidayah::findOrFail($id)->delete();
        session()->flash('error', 'تم رفض وحذف الهداية.');
    }

    public function render()
    {
        $pendingTadabburat = Tadabbur::where('status', 'pending')
            ->with(['user', 'majlis'])
            ->latest()
            ->paginate(10, ['*'], 'tadabburPage');

        $pendingHidayat = Hidayah::where('status', 'pending')
            ->with(['user', 'majlis'])
            ->latest()
            ->paginate(10, ['*'], 'hidayatPage');

        $approvedTadabburat = Tadabbur::where('status', 'approved')
            ->with(['user', 'majlis'])
            ->latest()
            ->paginate(10, ['*'], 'approvedPage');

        $counts = [
            'pending_tadabburat' => Tadabbur::where('status', 'pending')->count(),
            'pending_hidayat' => Hidayah::where('status', 'pending')->count(),
            'approved_total' => Tadabbur::where('status', 'approved')->count() + Hidayah::where('status', 'approved')->count(),
        ];

        return view('livewire.admin.tadabbur-moderation', [
            'pendingTadabburat' => $pendingTadabburat,
            'pendingHidayat' => $pendingHidayat,
            'approvedTadabburat' => $approvedTadabburat,
            'counts' => $counts,
        ])->layout('layouts.app');
    }
}
