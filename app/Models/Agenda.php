<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'judul', 'mulai', 'selesai', 'lokasi', 'deskripsi',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
    ];

    public function scopeMendatang($query)
    {
        return $query->where('mulai', '>=', now()->startOfDay());
    }
}
