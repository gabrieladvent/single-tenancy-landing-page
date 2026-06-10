<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Galeri extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'galeri';

    protected $fillable = [
        'judul', 'kategori', 'urutan',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto')->useDisk('public'); // banyak foto per album
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(600)->height(600)->nonQueued();
    }

    /** @return array<int, string> */
    public function fotoUrls(): array
    {
        return $this->getMedia('foto')->map(fn ($m) => $m->getUrl())->all();
    }
}
