<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SchoolSettings extends Settings
{
    // Identitas
    public string $nama_lengkap;
    public string $nama_singkat;
    public string $jenjang;        // SD | SMP | SMA | SMK
    public string $status;         // Negeri | Swasta
    public ?string $npsn;
    public ?string $akreditasi;
    public string $agama;          // islam | katolik | kristen | hindu | buddha | konghucu
    public string $moto;

    // Brand & tema (terbuka — lihat docs/desain.md)
    public string $style_pack;     // klasik | modern | hangat
    public string $preset_tema;    // biru-akademik | hijau-tumbuh | marun-klasik | tosca-modern
    public ?string $warna_utama;   // override hex dari logo (opsional)
    public ?string $warna_aksen;   // hex aksen (opsional)
    public ?string $logo;          // path relatif di disk public
    public ?string $hero_image;    // foto latar hero (opsional)

    // Lokalisasi
    public string $timezone;       // Asia/Jakarta | Asia/Makassar | Asia/Jayapura
    public string $locale;         // id

    // Kontak
    public ?string $alamat;
    public ?string $telepon;
    public ?string $whatsapp;
    public ?string $email;
    public ?string $jam_layanan;
    public ?string $peta_embed;

    // Sosial
    public ?string $instagram;
    public ?string $youtube;
    public ?string $facebook;
    public ?string $tiktok;

    // Modul & PPDB
    public array $modul_aktif;     // ['ppdb'=>true, 'berita'=>true, ...]
    public string $ppdb_mode;      // info | online
    public ?string $ppdb_link;     // tujuan tombol Daftar (v1)

    // Analytics
    public ?string $analytics_ga_id;

    public static function group(): string
    {
        return 'school';
    }
}
