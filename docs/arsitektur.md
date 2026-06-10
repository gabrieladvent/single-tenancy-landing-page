# Arsitektur & Implementasi — Website Sekolah (Single-Tenant, Reusable)

> **Sumber kebenaran teknis.** Satu deploy melayani **satu sekolah**. Kode bersifat **reusable**: sekolah baru = deploy salinan + isi Settings. Sisi **visual** ada di `desain.md`; **menu/sitemap** di `struktur.md`.

| Meta | Nilai |
|------|-------|
| Versi | 0.3 |
| Tanggal | 2026-06-10 |
| Status | Draf — single-tenant, stack terkunci |
| Model | 1 deploy = 1 sekolah (bukan SaaS multi-tenant) |
| Theming | **Runtime via Settings** (admin bisa ganti warna/logo/style pack tanpa redeploy) |

**Changelog**
- 0.3 — Tegaskan theming **runtime via Settings** (bukan seeder/env). Tambah garis config-deploy vs admin-editable (§3), maintenance N-clone via git (§12), Analytics & Cookie Consent (§9), catatan monogram logo (§12).
- 0.2 — Ganti dari multi-tenant ke **single-tenant**. Buang tenancy/SSL-otomatis/billing/kuota/onboarding-SaaS. Sederhanakan caching & SEO. Tambah alur deploy & "jalur ke multi-tenant".
- 0.1 — Draf arsitektur multi-tenant (digantikan).

**Daftar isi:** 1 Stack · 2 Struktur Aplikasi · 3 Model Data · 4 Peran & Izin · 5 Modul Keagamaan · 6 PPDB (v1 & jalur v2) · 7 Theming dari Settings · 8 Caching · 9 SEO · 10 Lokalisasi & Zona Waktu · 11 Email · 12 Deploy & Konfigurasi · 13 Jalur ke Multi-Tenant · 14 Out of Scope

---

## 1. Stack
```
Laravel 11
Filament 3                 → satu panel admin (staf sekolah)
Livewire 3 + Blade + Alpine + Tailwind  → situs publik (server-rendered, SEO beres)
spatie/laravel-settings     → konfigurasi sekolah (singleton)
spatie/laravel-medialibrary → logo, foto, galeri
spatie/laravel-permission   → peran staf (opsional, lihat §4)
Tailwind config (CSS variables) → token desain bersama admin & publik
```
Satu codebase, dua wajah, **semua PHP-rendered**. Tidak ada React/Inertia/SSR-Node, **tidak ada paket tenancy**.

## 2. Struktur Aplikasi
- **Publik** (`/`, `/profil/*`, `/berita/*`, `/ppdb`, dll) → Blade + Livewire.
- **Admin** (`/kelola`) → Filament: kelola konten + Settings.
- Tidak ada super-admin / tenant. Satu instance, satu sekolah, satu domain.

### Cakupan v1 (MVP)
**Dibangun di v1 (inti):** Beranda · Profil + sub-profil · PPDB (info) · Guru & Tendik · Fasilitas · Berita · Kontak · panel Filament · Settings/theming · seed konten contoh.
**v1.1:** Galeri · Ekstrakurikuler · Prestasi · Agenda.
**Nanti:** Download · Alumni · PPDB online (v2). Model/route modul non-v1 disiapkan strukturnya tapi belum diimplementasi.

## 3. Model Data (Eloquent + Filament Resource)

| Model | Field inti |
|-------|-----------|
| `Setting` (singleton) | nama_lengkap, nama_singkat, jenjang, status, npsn, akreditasi, agama, moto, style_pack, preset_tema, warna_utama, warna_aksen, logo, **timezone**, **locale**, kontak{alamat,telp,wa,email,jam}, sosial{...}, peta_embed, modul_aktif{...}, ppdb_mode, **ppdb_link** (tujuan tombol Daftar v1), **analytics_ga_id** |
| `Statistik` | label, angka, urutan (repeater — fleksibel) |
| `Halaman` | judul, slug, konten(rich), is_published, urutan_menu, **tipe**(sistem/kustom) — semua **sub-profil = Halaman** (di-seed slug tetap) + halaman kustom |
| `Berita` | judul, slug, tanggal, kategori, cover, ringkasan, isi, is_published, penulis_id |
| `Guru` | nama, foto, jabatan, mapel, tipe(guru/TU), urutan |
| `Prestasi` | nama, lomba, tingkat, tahun, peringkat |
| `Ekstrakurikuler` | nama, jadwal, pembina, foto |
| `Fasilitas` | nama, foto, deskripsi |
| `Galeri` + `GaleriItem` | judul, kategori; item: gambar, caption |
| `Agenda` (opsional) | judul, mulai, selesai (timezone sekolah), lokasi |
| `PesanKontak` | nama, email, pesan, dibaca, ip |
| `User` (staf) | nama, email, peran (§4) |

**Modul opsional** (`Setting.modul_aktif`): ppdb, galeri, ekstrakurikuler, prestasi, agenda, download, alumni, keagamaan → memengaruhi menu & route.

**Slug terpesan** (tak boleh dipakai Halaman kustom): `sejarah, visi-misi, sambutan-kepala-sekolah, struktur-organisasi, kerohanian`. Validasi saat admin membuat/mengubah Halaman.

> **Disiplin agar reusable & siap multi-tenant kelak:** tidak ada nama/warna/alamat di-hardcode — **semua dari Settings/DB**. Lihat §13.

### Config saat-deploy vs admin-editable (garis tegas)
| Lapisan | Tempat | Contoh | Siapa ubah |
|--------|--------|--------|-----------|
| **Infrastruktur** | `.env` | DB, domain, mail, app key, disk media | developer, saat deploy |
| **Identitas & tema** | Settings (DB) | nama, agama, warna, style pack, logo, kontak, timezone | **admin sekolah**, runtime |
| **Konten** | DB (model + Filament) | berita, guru, prestasi, galeri | **admin sekolah**, runtime |

Hanya hal infrastruktur yang butuh redeploy. Identitas, tema, dan konten **semua bisa diubah admin lewat panel** tanpa menyentuh kode.

## 4. Peran & Izin (opsional)
Untuk sekolah kecil dengan 1–2 admin, cukup peran bawaan Filament. Jika butuh pemisahan, pakai `spatie/laravel-permission`:

| Peran | Hak |
|-------|-----|
| Kepala Sekolah | lihat semua + kelola staf |
| Admin | kelola semua konten + Settings |
| Editor/Guru | tulis & edit Berita/Galeri sendiri |

Boleh ditunda sampai benar-benar dibutuhkan.

## 5. Modul Keagamaan (divalidasi sekolah)
`Setting.agama` ∈ {islam, katolik, kristen, hindu, buddha, konghucu}. Istilah hanya **saran awal yang bisa diedit admin** (hindari kekeliruan teologis):

| Slot | islam | katolik | kristen | hindu | buddha | konghucu |
|------|-------|---------|---------|-------|--------|----------|
| ruang_ibadah | Musala | Kapel | Ruang Ibadah | Pura | Cetiya | Litang |
| sapaan | Assalamualaikum | Salam sejahtera | Salam sejahtera | Om Swastiastu | Namo Buddhaya | Wei De Dong Tian |

- `nilai_inti`, `kegiatan_rohani` = **teks bebas** diisi sekolah.
- Sekolah lintas-iman → modul dimatikan → section "Karakter & Nilai" umum.
- Warna **tidak** ikut agama; tetap dari brand sekolah.

## 6. PPDB — v1 Info, Jalur v2 Pendaftaran Online
**v1 (sekarang): halaman info.** Alur, syarat, jadwal, biaya, FAQ, kontak panitia. Tombol "Daftar" → WhatsApp / Google Form eksternal (dari Settings).

**Jalur v2 (disiapkan, belum dibangun):**
- Slot route `/ppdb/daftar` (v1 redirect ke link eksternal).
- Model `Pendaftar` dicadangkan: nama, ortu, asal sekolah, berkas(media), status, gelombang. **Belum dibuat** — agar migrasi v2 aditif.
- `Setting.ppdb_mode`: `info` (v1) | `online` (v2).

## 7. Theming dari Settings (alur)
```
Request → load Settings (tema/logo/style-pack/warna)
→ render <head> inline :root{ --brand-500:…; --font-heading:…; --radius-md:… }
→ Blade/Tailwind baca CSS variables → tampil sesuai brand sekolah
```
- CSS variables **di-inline di `<head>`**. Tailwind: `colors:{ brand:'var(--brand-500)' }`.
- **Ramp dari satu hex logo:** fungsi server (OKLCH lighten/darken) hasilkan `brand-50..900`. Aksen **dipilih** admin dari daftar aman (`desain.md` §3), bukan ditebak.
- **Validasi kontras saat simpan Settings:** hitung rasio teks-di-brand-500; jika < 4.5:1 → **peringatkan/tolak** + sarankan pergelap.
- **Tema sepenuhnya runtime via Settings** — admin ganti warna/logo/style pack → langsung berubah tanpa redeploy. (Seeder hanya mengisi nilai awal saat fresh install; sesudahnya Settings yang berkuasa.)

## 8. Caching (sederhana)
- **Cache penuh** halaman **statis** (beranda, profil, berita detail, fasilitas, guru). Invalidasi saat konten diubah di Filament (event model).
- **Tanpa cache penuh** halaman ber-form/filter (kontak, filter) — hindari cache HTML ber-CSRF; pakai fragment cache untuk bagian statisnya.
- Gambar: medialibrary → WebP/AVIF + srcset. Opsional CDN.
- Font: subset latin, `font-display: swap`, maks 2 file/style-pack (preload).
- Target: LCP <2.5s 4G, halaman awal <1MB, Lighthouse Perf & A11y ≥90.

## 9. SEO
- `<title>` unik `"{halaman} — {nama_lengkap}"`, meta description per halaman, Open Graph.
- **Sitemap.xml & robots.txt** (satu domain). Canonical.
- Schema.org `School` dari Settings (nama/alamat/geo/telp).
- URL bersih: `/ppdb`, `/profil/sejarah`, `/berita/{slug}`.
- **Filter Livewire & SEO:** render awal **server-side** menghormati query param (`?tipe=guru`); **pagination pakai `<a href>` asli** (bukan tombol AJAX) agar crawl-able.

### Analytics & Cookie Consent
- **Google Analytics (GA4)** opsional: ID diisi di Settings (kosong = nonaktif). Skrip dimuat hanya bila ID terisi.
- **Banner cookie consent** muncul bila analytics aktif; skrip GA baru jalan **setelah** persetujuan (gaya banner di `desain.md` §8).
- Hormati Do-Not-Track. Tanpa analytics → tanpa banner (situs tetap bersih).

## 10. Lokalisasi & Zona Waktu
- `Setting.timezone` ∈ **WIB (Asia/Jakarta) · WITA (Asia/Makassar) · WIT (Asia/Jayapura)**. Semua tanggal/agenda pakai timezone sekolah.
- `Setting.locale` = `id` (format "10 Juni 2026").
- Simpan timestamp UTC di DB, tampil di timezone sekolah.

## 11. Email
- Form kontak & notifikasi kirim dari email sekolah (Settings).
- Panduan **SPF/DKIM/DMARC** agar tidak masuk spam (untuk domain sekolah).
- Anti-spam form: honeypot + rate-limit + (opsional) captcha.

## 12. Deploy & Konfigurasi (per sekolah)
1. Clone **starter repo** → `composer install` → `npm run build`.
2. Set `.env` (DB, domain, mail).
3. `php artisan migrate --seed` → **seed konten contoh** (1 berita, profil placeholder, **monogram logo**) supaya situs tidak kosong. Monogram = inisial sekolah di lingkaran `brand-700`, di-generate sebagai SVG sampai logo asli diunggah.
4. Buat akun admin (`php artisan make:filament-user` / seeder).
5. Login `/kelola` → **Wizard Settings:** nama, agama, style pack/preset, logo, kontak, timezone.
6. Pasang domain + SSL **biasa** (Let's Encrypt via web server / panel hosting) — tidak ada otomasi multi-domain.
7. Backup DB + folder media terjadwal (cron sederhana).

### Maintenance banyak deploy (konsekuensi single-tenant)
Tiap sekolah = salinan sendiri, jadi perbaikan/fitur perlu disebar ke tiap deploy. Agar tidak manual:
- Semua deploy berasal dari **satu starter repo** + tag versi. Tiap deploy `git pull` / `git merge` rilis baru → `composer install && npm run build && php artisan migrate`.
- **Konten & Settings ada di DB**, bukan di kode → update kode aman, tidak menimpa data sekolah.
- Otomasi opsional: script/CI yang men-deploy rilis ke daftar server. (Inilah harga single-tenant; bila jumlah sekolah membengkak → pertimbangkan §13.)

## 13. Jalur ke Multi-Tenant (kalau perlu nanti — jangan dibangun sekarang)
Supaya naik ke SaaS tetap **aditif**, jaga 3 disiplin ini sejak awal:
1. **Semua data sekolah lewat Settings/DB** — tidak ada hardcode.
2. **Model konten bersih** — nanti tinggal tambah kolom `tenant_id` + global scope.
3. **Tema dari CSS variables runtime** — sudah per-request, tinggal sumbernya diganti per-tenant.

Saat itu tiba: tambah `stancl/tenancy`, kolom tenant, panel super-admin, custom domain/SSL, billing. **Bukan tulis ulang.**

## 14. Out of Scope (v1)
TIDAK termasuk kecuali diminta: dark mode · multi-bahasa (EN) · login siswa/portal nilai/rapor/e-learning/CBT · **PPDB online (v2)** · pembayaran SPP · aplikasi native · **multi-tenant/SaaS** (lihat §13).

---

## Checklist Teknis (per fitur)
- [ ] Tak ada nama/warna/alamat di markup — semua dari Settings.
- [ ] Settings tervalidasi (kontras warna saat simpan; timezone wajib).
- [ ] Cache halaman statis; form/filter tidak di-cache penuh.
- [ ] Sitemap/robots/canonical benar.
- [ ] Filter Livewire: render awal server + pagination link asli.
- [ ] Tanggal pakai timezone & locale sekolah.
- [ ] Seed konten contoh ada (situs tak kosong saat fresh install).
- [ ] Route `/ppdb/daftar` ada (v1 redirect eksternal).
- [ ] Backup DB + media terjadwal.
- [ ] Lighthouse Perf & A11y ≥90.

---

*Perubahan arsitektur diperbarui di sini lebih dulu, baru di kode. Visual → `desain.md`.*
