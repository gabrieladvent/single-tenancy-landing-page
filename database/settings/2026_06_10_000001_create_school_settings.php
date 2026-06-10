<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Identitas (placeholder — diisi admin lewat panel)
        $this->migrator->add('school.nama_lengkap', 'Sekolah Contoh');
        $this->migrator->add('school.nama_singkat', 'Sekolah');
        $this->migrator->add('school.jenjang', 'SMP');
        $this->migrator->add('school.status', 'Swasta');
        $this->migrator->add('school.npsn', '');
        $this->migrator->add('school.akreditasi', '');
        $this->migrator->add('school.agama', 'islam');
        $this->migrator->add('school.moto', 'Buka Pikiran, Sentuh Hati, Bentuk Masa Depan');

        // Brand & tema
        $this->migrator->add('school.style_pack', 'klasik');
        $this->migrator->add('school.preset_tema', 'biru-akademik');
        $this->migrator->add('school.warna_utama', null);
        $this->migrator->add('school.warna_aksen', null);
        $this->migrator->add('school.logo', null);

        // Lokalisasi
        $this->migrator->add('school.timezone', 'Asia/Jakarta');
        $this->migrator->add('school.locale', 'id');

        // Kontak
        $this->migrator->add('school.alamat', '');
        $this->migrator->add('school.telepon', '');
        $this->migrator->add('school.whatsapp', '');
        $this->migrator->add('school.email', '');
        $this->migrator->add('school.jam_layanan', 'Senin–Jumat 07.00–15.00 WIB');
        $this->migrator->add('school.peta_embed', null);

        // Sosial
        $this->migrator->add('school.instagram', null);
        $this->migrator->add('school.youtube', null);
        $this->migrator->add('school.facebook', null);
        $this->migrator->add('school.tiktok', null);

        // Modul & PPDB
        $this->migrator->add('school.modul_aktif', [
            'ppdb' => true,
            'berita' => true,
            'galeri' => false,
            'ekstrakurikuler' => false,
            'prestasi' => false,
            'agenda' => false,
            'download' => false,
            'alumni' => false,
            'keagamaan' => true,
        ]);
        $this->migrator->add('school.ppdb_mode', 'info');
        $this->migrator->add('school.ppdb_link', null);

        // Analytics
        $this->migrator->add('school.analytics_ga_id', null);
    }
};
