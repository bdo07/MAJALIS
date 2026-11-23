<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'majlis_id',
        'surah_number',
        'ayah_number',
        'title',
        'subtitle',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }

    /**
     * Generate the direct URL to the bookmarked item.
     */
    public function getUrlAttribute(): string
    {
        if ($this->type === 'majlis' && $this->majlis) {
            return route('majalis.show', $this->majlis);
        }

        if ($this->surah_number) {
            $url = route('quran.show', $this->surah_number);
            if ($this->ayah_number) {
                $url .= '#ayah-' . $this->ayah_number;
            }
            return $url;
        }

        return route('majalis.index');
    }

    /**
     * Get a descriptive badge label in Arabic.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'majlis' => 'مجلس قرآني',
            'surah' => 'سورة كريمة',
            'ayah' => 'آية بينة',
            default => 'علامة مرجعية',
        };
    }
}
