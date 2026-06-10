<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Fasilitas extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'fasilitas';

    protected $fillable = [
        'nama', 'deskripsi', 'urutan',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('kartu')->width(800)->height(500)->nonQueued();
    }

    public function fotoUrl(): ?string
    {
        return $this->getFirstMediaUrl('foto') ?: null;
    }
}
