<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\Halaman;
use App\Models\Statistik;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin panel
        User::updateOrCreate(
            ['email' => 'admin@sekolah.test'],
            ['name' => 'Admin Sekolah', 'password' => bcrypt('password')],
        );

        // Sub-profil (tipe=sistem, slug terpesan) — docs/struktur.md §3
        $subProfil = [
            'sejarah' => 'Sejarah',
            'visi-misi' => 'Visi & Misi',
            'sambutan-kepala-sekolah' => 'Sambutan Kepala Sekolah',
            'struktur-organisasi' => 'Struktur Organisasi',
            'kerohanian' => 'Kerohanian',
        ];
        foreach ($subProfil as $slug => $judul) {
            Halaman::updateOrCreate(
                ['slug' => $slug],
                [
                    'judul' => $judul,
                    'tipe' => 'sistem',
                    'is_published' => true,
                    'konten' => "<p>Konten <strong>{$judul}</strong> dapat diisi melalui panel admin.</p>",
                ],
            );
        }

        // Statistik (contoh — ISI DATA ASLI)
        if (Statistik::count() === 0) {
            foreach ([
                ['label' => 'Tahun Berdiri', 'angka' => '—'],
                ['label' => 'Siswa Aktif', 'angka' => '—'],
                ['label' => 'Guru & Tendik', 'angka' => '—'],
                ['label' => 'Akreditasi', 'angka' => '—'],
            ] as $i => $s) {
                Statistik::create([...$s, 'urutan' => $i]);
            }
        }

        // Berita contoh
        if (Berita::count() === 0) {
            Berita::create([
                'judul' => 'Selamat Datang di Website Sekolah',
                'slug' => 'selamat-datang',
                'tanggal' => now(),
                'kategori' => 'Pengumuman',
                'ringkasan' => 'Website resmi sekolah kini hadir dengan tampilan baru.',
                'isi' => '<p>Selamat datang! Pantau berita dan informasi terbaru di sini.</p>',
                'is_published' => true,
            ]);
        }

        // Guru & Fasilitas contoh
        if (Guru::count() === 0) {
            Guru::create(['nama' => 'Nama Guru', 'jabatan' => 'Kepala Sekolah', 'tipe' => 'guru', 'urutan' => 0]);
        }
        if (Fasilitas::count() === 0) {
            Fasilitas::create(['nama' => 'Perpustakaan', 'deskripsi' => 'Ruang baca yang nyaman.', 'urutan' => 0]);
        }

        // Modul v1.1 — contoh
        if (\App\Models\Prestasi::count() === 0) {
            \App\Models\Prestasi::insert([
                ['nama' => 'Juara Lomba Cerdas Cermat', 'lomba' => 'LCC Tingkat Kota', 'tingkat' => 'Kota', 'peringkat' => 'Juara 1', 'tahun' => 2025, 'urutan' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Juara Olimpiade Sains', 'lomba' => 'OSN', 'tingkat' => 'Provinsi', 'peringkat' => 'Juara 2', 'tahun' => 2024, 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        if (\App\Models\Ekstrakurikuler::count() === 0) {
            \App\Models\Ekstrakurikuler::insert([
                ['nama' => 'Pramuka', 'jadwal' => 'Jumat 14.00', 'pembina' => 'Kak Budi', 'deskripsi' => 'Kegiatan kepramukaan.', 'urutan' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['nama' => 'Futsal', 'jadwal' => 'Selasa 15.30', 'pembina' => 'Coach Andi', 'deskripsi' => 'Latihan futsal rutin.', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        if (\App\Models\Agenda::count() === 0) {
            \App\Models\Agenda::create(['judul' => 'Penerimaan Rapor', 'mulai' => now()->addDays(7)->setTime(8, 0), 'lokasi' => 'Aula Sekolah']);
        }
    }
}
