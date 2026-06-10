<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Guru extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'guru';

    protected $fillable = [
        'nama', 'jabatan', 'mapel', 'tipe', 'urutan',
    ];

    public function scopeGuru($query)
    {
        return $query->where('tipe', 'guru');
    }

    public function scopeTendik($query)
    {
        return $query->where('tipe', 'tu');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('potret')->width(500)->height(500)->nonQueued();
    }

    public function fotoUrl(): ?string
    {
        return $this->getFirstMediaUrl('foto') ?: null;
    }
}
