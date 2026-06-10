<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    protected $table = 'halaman';

    protected $fillable = [
        'judul', 'slug', 'konten', 'tipe', 'is_published', 'urutan_menu',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /** Slug sub-profil bawaan yang tak boleh dipakai Halaman kustom. */
    public const SLUG_TERPESAN = [
        'sejarah',
        'visi-misi',
        'sambutan-kepala-sekolah',
        'struktur-organisasi',
        'kerohanian',
    ];

    protected static function booted(): void
    {
        static::saving(function (Halaman $halaman) {
            if (blank($halaman->slug)) {
                $halaman->slug = \Illuminate\Support\Str::slug($halaman->judul);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
