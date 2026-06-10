<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Berita extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'tanggal', 'kategori', 'ringkasan', 'isi',
        'is_published', 'penulis_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Berita $berita) {
            if (blank($berita->slug)) {
                $berita->slug = \Illuminate\Support\Str::slug($berita->judul);
            }
            if (blank($berita->penulis_id) && auth()->check()) {
                $berita->penulis_id = auth()->id();
            }
        });
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('kartu')->width(800)->height(500)->nonQueued();
    }

    public function coverUrl(): ?string
    {
        return $this->getFirstMediaUrl('cover') ?: null;
    }
}
