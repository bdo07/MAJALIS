<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Majlis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MajlisManager extends Component
{
    use WithPagination;

    public $search = '';
    public $majlisId = null;
    public $title = '';
    public $description = '';
    public $is_published = true;

    public $isOpen = false;
    public $isEditMode = false;

    public $historyModalOpen = false;
    public $selectedMajlisHistory = [];
    public $selectedMajlisTitle = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_published' => 'boolean',
        ];
    }

    public function boot()
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة الإدارة.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        $majlis = Majlis::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title) ?: Str::random(10),
            'description' => $this->description,
            'is_published' => $this->is_published,
        ]);

        // تسجيل حدث الإنشاء في جدول التاريخ
        DB::table('majlis_histories')->insert([
            'majlis_id' => $majlis->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'old_content' => null,
            'new_content' => "تم إنشاء المجلس بعنوان: {$this->title}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('message', 'تم إنشاء المجلس القرآني بنجاح.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $majlis = Majlis::findOrFail($id);
        $this->majlisId = $majlis->id;
        $this->title = $majlis->title;
        $this->description = $majlis->description;
        $this->is_published = (bool) $majlis->is_published;

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $majlis = Majlis::findOrFail($this->majlisId);

        if ($majlis->title === $this->title && $majlis->description === $this->description && (bool)$majlis->is_published === (bool)$this->is_published) {
            session()->flash('error', 'لم يتم اكتشاف أي تغييرات جديدة على بيانات المجلس.');
            $this->closeModal();
            return;
        }

        DB::table('majlis_histories')->insert([
            'majlis_id' => $majlis->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'old_content' => "العنوان السابق: {$majlis->title} | الوصف: " . Str::limit($majlis->description, 50),
            'new_content' => "العنوان الجديد: {$this->title} | الوصف: " . Str::limit($this->description, 50),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $majlis->update([
            'title' => $this->title,
            'description' => $this->description,
            'is_published' => $this->is_published,
        ]);

        session()->flash('message', 'تم تحديث بيانات المجلس وسجل التدقيق بنجاح.');
        $this->closeModal();
    }

    public function togglePublish($id)
    {
        $majlis = Majlis::findOrFail($id);
        $newStatus = !$majlis->is_published;
        $majlis->update(['is_published' => $newStatus]);

        DB::table('majlis_histories')->insert([
            'majlis_id' => $majlis->id,
            'user_id' => auth()->id(),
            'action' => $newStatus ? 'published' : 'unpublished',
            'old_content' => 'الحالة السابقة: ' . ($newStatus ? 'مسودة' : 'منشور'),
            'new_content' => 'الحالة الجديدة: ' . ($newStatus ? 'منشور للعامة' : 'مسودة مخفية'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('message', 'تم تغيير حالة نشر المجلس بنجاح.');
    }

    public function delete($id)
    {
        Majlis::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف المجلس بنجاح.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->majlisId = null;
        $this->title = '';
        $this->description = '';
        $this->is_published = true;
    }

    public function showHistory($id)
    {
        $majlis = Majlis::findOrFail($id);
        $this->selectedMajlisTitle = $majlis->title;

        $this->selectedMajlisHistory = DB::table('majlis_histories')
            ->where('majlis_id', $id)
            ->join('users', 'majlis_histories.user_id', '=', 'users.id')
            ->select('majlis_histories.*', 'users.name as user_name')
            ->latest('majlis_histories.created_at')
            ->get();

        $this->historyModalOpen = true;
    }

    public function closeHistoryModal()
    {
        $this->historyModalOpen = false;
        $this->selectedMajlisHistory = [];
        $this->selectedMajlisTitle = '';
    }

    public function render()
    {
        $majalis = Majlis::query()
            ->with('user')
            ->withCount(['ayat', 'tadabburat', 'hidayat'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.majlis-manager', [
            'majalis' => $majalis
        ])->layout('layouts.app');
    }
}
