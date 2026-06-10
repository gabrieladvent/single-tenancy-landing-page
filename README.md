# 🎓 Website Sekolah — Template Reusable (Single-Tenant)

Template website sekolah **berbasis agama** yang dapat dipakai ulang: satu deploy untuk satu sekolah, seluruh identitas (nama, logo, warna, tema, kontak, konten) diatur lewat **panel admin** tanpa menyentuh kode.

Dibangun dengan **Laravel + Filament + Livewire + Tailwind**, dengan sistem tema runtime (ganti warna/font/logo langsung dari panel) dan modul yang bisa dinyalakan/dimatikan per sekolah.

> Dokumen desain & arsitektur lengkap ada di folder [`docs/`](docs/): [`desain.md`](docs/desain.md) (sistem visual), [`arsitektur.md`](docs/arsitektur.md) (teknis), [`struktur.md`](docs/struktur.md) (sitemap/IA).

---

## ✨ Fitur

- **Panel admin (Filament)** di `/kelola` — kelola semua konten & pengaturan.
- **Pengaturan sekolah lewat UI** — identitas, tema, kontak, sosial, modul, PPDB, analytics.
- **Sistem tema runtime** — 4 preset warna + 3 style pack (tipografi+radius), atau warna dari logo (ramp otomatis + validasi kontras WCAG).
- **Modul on/off** — nyalakan/matikan fitur per sekolah; menu & route ikut otomatis (mati = 404).
- **Hak akses (Filament Shield)** — peran & izin per pengguna.
- **Rich text editor** untuk berita & halaman; **upload media** (logo, cover, foto guru/fasilitas/ekskul, galeri).
- **SEO** — sitemap.xml, robots.txt, Open Graph, Schema.org `School`, meta per halaman.
- **Lokalisasi Indonesia** — tanggal & zona waktu (WIB/WITA/WIT).
- **Responsif & aksesibel** — mobile-first, skip-to-content, fokus keyboard.

### Modul

| Inti (selalu ada) | Opsional (toggle) |
|-------------------|-------------------|
| Beranda · Profil + sub-profil · Guru & Tendik · Fasilitas · Kontak | PPDB (info) · Berita · Prestasi · Ekstrakurikuler · Galeri · Agenda · Kerohanian |

---

## 🧱 Stack

| Lapisan | Teknologi |
|---------|-----------|
| Backend | Laravel 13 (PHP 8.4) |
| Admin | Filament 5 |
| Publik | Livewire 3 + Blade + Alpine.js |
| Styling | Tailwind CSS v4 (token via CSS variables) |
| Pengaturan | spatie/laravel-settings |
| Media | spatie/laravel-medialibrary |
| Hak akses | bezhanSalleh/filament-shield + spatie/laravel-permission |
| Database | SQLite (default dev) / MySQL / PostgreSQL |

---

## 🚀 Instalasi

**Prasyarat:** PHP 8.3+, Composer, Node.js 20+, npm.

```bash
# 1. Install dependency
composer install
npm install

# 2. Environment
cp .env.example .env        # jika belum ada .env
php artisan key:generate

# 3. Database + data contoh (admin, sub-profil, konten dummy)
php artisan migrate --seed

# 4. Symlink storage (untuk gambar)
php artisan storage:link

# 5. Build aset front-end
npm run build
```

### Menjalankan

```bash
# Pengembangan (hot reload)
composer dev          # menjalankan serve + queue + vite sekaligus
# atau manual:
php artisan serve     # http://127.0.0.1:8000
npm run dev           # biarkan jalan agar CSS/JS live
```

> **Catatan Vite:** saat `npm run dev` aktif ada file `public/hot`. Untuk versi produksi, **hentikan dev**, **hapus `public/hot`**, lalu `npm run build`.

### Akun admin default (dari seeder)

```
URL      : /kelola
Email    : admin@sekolah.test
Password : password
```

---

## ⚙️ Konfigurasi Sekolah

Semua identitas diatur lewat panel — **tidak ada yang di-hardcode**.

1. Login ke `/kelola`.
2. Buka **Pengaturan Sekolah** (grup *Pengaturan*).
3. Isi tab: **Identitas · Tema · Kontak · Sosial · Modul · PPDB & Lain-lain**.
   - **Tema:** pilih style pack & preset warna, atau unggah logo + warna utama (ramp & kontras otomatis), plus foto latar hero.
   - **Modul:** nyalakan/matikan fitur — menu & halaman publik menyesuaikan.
   - **Lokalisasi:** pilih zona waktu (WIB/WITA/WIT).

Lalu isi konten lewat menu di grup **Konten** (Berita, Halaman, Galeri, Agenda) & **Sekolah** (Guru, Fasilitas, Prestasi, Ekstrakurikuler, Statistik).

### Layer konfigurasi

| Lapisan | Tempat | Diubah oleh |
|---------|--------|-------------|
| Infrastruktur (DB, domain, mail) | `.env` | developer (deploy) |
| Identitas & tema | Pengaturan (panel) | admin sekolah |
| Konten | panel | admin sekolah |

---

## 📁 Struktur Singkat

```
app/
├─ Filament/Resources/   # CRUD admin per entitas
├─ Filament/Pages/       # PengaturanSekolah (settings)
├─ Models/               # Berita, Guru, Fasilitas, Halaman, Prestasi, ...
├─ Settings/             # SchoolSettings (spatie)
└─ Support/Theme.php     # tema runtime: preset, style pack, ramp, kontras
resources/
├─ css/app.css           # design token (CSS variables) + dekorasi
├─ views/layouts/        # layout publik (inject tema, SEO)
├─ views/partials/       # topbar, header, footer, cookie-consent
├─ views/public/         # halaman publik
└─ views/components/     # ico, section-heading, page-hero
routes/web.php           # route publik + sitemap
docs/                    # desain.md, arsitektur.md, struktur.md
```
---

## 🧭 Catatan

- Foto disimpan di disk `public` (butuh `storage:link`). URL mengikuti `APP_URL`.
- Galeri perlu diisi foto dulu baru tampil.
- **Out of scope v1:** dark mode, multi-bahasa, login siswa/portal nilai, PPDB online (disiapkan untuk v2), multi-tenant/SaaS.

---
