# Struktur Situs — Website Sekolah (Sitemap, Routing, Navigasi)

> **Sumber kebenaran arsitektur informasi (IA).** Apa saja halamannya, susunannya, URL-nya, dan blok konten tiap halaman. Sisi **visual** di `desain.md`; **teknis/model** di `arsitektur.md`.

| Meta | Nilai |
|------|-------|
| Versi | 0.1 |
| Tanggal | 2026-06-10 |
| Status | Draf — selaras single-tenant, modul opsional |

**Daftar isi:** 1 Prinsip IA · 2 Peta Situs · 3 Tabel Routing · 4 Navigasi Header · 5 Navigasi Footer · 6 Breadcrumb · 7 Perilaku Modul (toggle) · 8 Konten per Halaman · 9 Halaman Sistem · 10 Checklist

---

## 1. Prinsip IA
- **Dangkal & jelas:** maksimal 2 level menu. Orang tua cari info cepat di HP.
- **Inti selalu ada, sisanya modul** yang bisa dimatikan per sekolah (`Setting.modul_aktif`).
- **Menu mengikuti modul:** modul mati → item menu & route-nya hilang otomatis.
- **PPDB menonjol** (halaman konversi) — selalu terlihat di header, bukan dalam dropdown.
- Satu top-level dropdown tidak lebih dari ~6 item.

## 2. Peta Situs

Legenda: **●** inti (selalu ada) · **○** modul opsional (toggle) · `↳` sub-halaman

```
● Beranda                         /
● Profil                          /profil
  ↳ Sejarah                       /profil/sejarah
  ↳ Visi & Misi                   /profil/visi-misi
  ↳ Sambutan Kepala Sekolah       /profil/sambutan-kepala-sekolah
  ↳ Struktur Organisasi           /profil/struktur-organisasi
  ↳ Kerohanian / Nilai*           /profil/kerohanian
  ↳ [Halaman kustom]              /profil/{slug}      (model Halaman)
● PPDB                            /ppdb
  ↳ Daftar                        /ppdb/daftar        (v1: redirect eksternal)
● Guru & Tendik                   /guru
● Fasilitas                       /fasilitas
○ Ekstrakurikuler                 /ekstrakurikuler
○ Prestasi                        /prestasi
○ Berita                          /berita
  ↳ Detail berita                 /berita/{slug}
  ↳ Kategori                      /berita/kategori/{kategori}
○ Agenda                          /agenda
○ Galeri                          /galeri
  ↳ Album/kategori                /galeri/{kategori}
○ Download                        /download
○ Alumni                          /alumni
● Kontak                          /kontak

Sistem: /cari · /404 · /sitemap.xml · /robots.txt
```
*Kerohanian/Nilai = modul keagamaan (Bagian 7 `arsitektur.md`); mati → diganti "Karakter & Nilai" umum atau disembunyikan.

## 3. Tabel Routing

| URL | Halaman | Sumber data | Modul |
|-----|---------|-------------|-------|
| `/` | Beranda | agregasi (Setting, Berita, Prestasi, Statistik) | inti |
| `/profil` | Ringkasan profil | Setting + Halaman | inti |
| `/profil/sejarah` | Sejarah | Halaman (slug=sejarah) | inti |
| `/profil/visi-misi` | Visi & Misi | Halaman (slug=visi-misi) | inti |
| `/profil/sambutan-kepala-sekolah` | Sambutan kepsek | Halaman (slug=sambutan-kepala-sekolah) | inti |
| `/profil/struktur-organisasi` | Struktur organisasi | Halaman (slug=struktur-organisasi) | inti |
| `/profil/kerohanian` | Kerohanian/Nilai | Setting (slot agama) + Halaman | keagamaan |
| `/profil/{slug}` | Halaman kustom | Halaman | inti |
| `/ppdb` | Info PPDB | Halaman / Setting | inti |
| `/ppdb/daftar` | Daftar | v1: redirect `Setting.ppdb_link` · v2: form `Pendaftar` | inti |
| `/guru` | Guru & Tendik | Guru (filter tipe) | inti |
| `/fasilitas` | Fasilitas | Fasilitas | inti |
| `/ekstrakurikuler` | Ekstrakurikuler | Ekstrakurikuler | ○ |
| `/prestasi` | Prestasi | Prestasi | ○ |
| `/berita` | Daftar berita | Berita (paginasi) | ○ |
| `/berita/{slug}` | Detail berita | Berita | ○ |
| `/berita/kategori/{kategori}` | Berita per kategori | Berita | ○ |
| `/agenda` | Agenda/kalender | Agenda | ○ |
| `/galeri` | Galeri | Galeri | ○ |
| `/galeri/{kategori}` | Album | Galeri/GaleriItem | ○ |
| `/download` | Unduhan | (media/dokumen) | ○ |
| `/alumni` | Alumni | (konten) | ○ |
| `/kontak` | Kontak + form | Setting + PesanKontak | inti |
| `/cari` | Hasil pencarian | Berita/Halaman | inti |

Aturan: route modul opsional **hanya didaftarkan** bila modul aktif → URL mati = 404 bersih (bukan halaman kosong).

**Sub-profil = model `Halaman`** (di-seed dengan slug tetap, `tipe=sistem`, bisa diedit admin). Halaman kustom (`tipe=kustom`) pakai `/profil/{slug}`. **Slug terpesan** (tak boleh dipakai kustom): `sejarah, visi-misi, sambutan-kepala-sekolah, struktur-organisasi, kerohanian` — divalidasi saat simpan.

> **Cakupan v1 (MVP):** route bertanda inti (●) + Berita. Modul ○ lain (Galeri/Ekskul/Prestasi/Agenda/Download/Alumni) menyusul; route-nya tidak didaftarkan sampai diimplementasi.

## 4. Navigasi Header

Struktur (≤6 top-level, PPDB sebagai CTA aksen):

```
[Logo + Nama]   Beranda   Profil▾   PPDB   Akademik▾   Informasi▾   Kontak   [▸PPDB]
```

| Top-level | Isi dropdown | Catatan |
|-----------|--------------|---------|
| Beranda | — | link langsung |
| **Profil** ▾ | Sejarah · Visi & Misi · Sambutan Kepsek · Struktur Organisasi · Kerohanian* · (Halaman kustom) | item Kerohanian ikut modul keagamaan |
| **PPDB** | — | selalu terlihat (penting) |
| **Akademik** ▾ | Guru & Tendik · Fasilitas · Ekstrakurikuler○ · Prestasi○ | item ○ hilang bila modul mati |
| **Informasi** ▾ | Berita○ · Agenda○ · Galeri○ · Download○ | dropdown hilang bila semua isinya mati |
| Kontak | — | link langsung |

Perilaku:
- **Tombol aksen "Daftar PPDB"** di kanan header (CTA), terpisah dari menu.
- **Dropdown** muncul 200ms (desain.md §8/§12); bisa dibuka keyboard.
- **< 1024px:** hamburger → drawer kanan; dropdown jadi accordion.
- **Active state:** item halaman aktif diberi underline aksen + warna brand-700.
- **Urutan & label** dapat di-override admin (Halaman.urutan_menu); item modul mengikuti toggle.

> Catatan: pengelompokan "Akademik"/"Informasi" hanya untuk merapikan. Jika sekolah ingin flat (semua di top-level), sediakan **mode menu**: `grouped` (default) | `flat`.

## 5. Navigasi Footer

4 kolom (desain.md §8):

| Kolom 1 | Kolom 2 — Profil | Kolom 3 — Informasi | Kolom 4 — Terhubung |
|---------|------------------|---------------------|---------------------|
| Logo + nama | Sejarah | Berita○ | Alamat |
| Moto | Visi & Misi | Agenda○ | Jam layanan |
| Ringkas 1 kalimat | Sambutan Kepsek | Galeri○ | Telp / WA / Email |
| | PPDB | Download○ | Ikon sosial |

Baris bawah: `© {tahun} {nama_lengkap}` + moto + link `/sitemap.xml`. Item ○ hilang bila modul mati.

## 6. Breadcrumb
- Muncul di semua halaman **kecuali Beranda**.
- Pola: `Beranda / {Induk} / {Halaman}` — mis. `Beranda / Profil / Sejarah`.
- Detail berita: `Beranda / Berita / {Judul}`.
- Halaman aktif tidak jadi link. Pakai Schema.org `BreadcrumbList`.

## 7. Perilaku Modul (toggle `Setting.modul_aktif`)

Saat modul dimatikan:
1. **Route tidak didaftarkan** → akses langsung = 404.
2. **Item menu hilang** (header & footer).
3. **Dropdown kosong otomatis disembunyikan** (mis. semua Informasi mati → dropdown Informasi hilang).
4. **Blok di Beranda terkait modul disembunyikan** (mis. Prestasi mati → section Prestasi di beranda hilang).
5. **Tidak masuk sitemap.xml.**

| Modul | Default | Mematikan menghilangkan |
|-------|---------|-------------------------|
| ppdb | on | (inti — disarankan tetap on) |
| ekstrakurikuler | on | menu + section beranda |
| prestasi | on | menu + section beranda + timeline |
| berita | on | menu + section beranda + footer |
| agenda | off | menu Informasi |
| galeri | on | menu + lightbox |
| download | off | menu Informasi |
| alumni | off | menu |
| keagamaan | on | sub-profil Kerohanian + section beranda |

## 8. Konten per Halaman (urutan blok)

Mengacu wireframe `desain.md` §7-8. Tiap blok = section dengan pola "label + judul serif + aksen".

**Beranda** — Hero → Sambutan kepsek → Statistik (band) → Visi-Misi → Kerohanian* → Keunggulan (3 kartu) → Berita (1+2)○ → Prestasi (timeline 3)○ → CTA band PPDB → Footer.

**Profil (ringkasan)** — Hero kecil + breadcrumb → narasi identitas (akreditasi/NPSN dari Setting) → kartu tautan ke sub-profil → CTA.

**Sub-profil** (Sejarah/Visi-Misi/Sambutan/Struktur/Kerohanian) — Hero kecil → konten (teks 65ch + sidebar foto/kutipan) → navigasi antar sub-profil → CTA.

**PPDB** — Hero kecil → Alur (stepper 4) → Syarat (checklist) → Jadwal (tabel, tenggat=warning) → Biaya (opsional) → ▸Daftar (tombol **aksen**, satu-satunya) → FAQ accordion → Kontak panitia.

**Guru & Tendik** — Hero kecil → filter (Semua/Guru/TU, Livewire+querystring) → grid kartu (foto+nama+jabatan) 3/2/1 kolom → paginasi link asli.

**Fasilitas** — Hero kecil → grid kartu (foto+nama+deskripsi).

**Ekstrakurikuler** — Hero kecil → grid kartu (nama+jadwal+pembina+foto).

**Prestasi** — Hero kecil → timeline/daftar (nama, lomba, tingkat, tahun, peringkat) → filter tahun (opsional).

**Berita (daftar)** — Hero kecil → 1 unggulan + grid → filter kategori → paginasi link asli. **Detail** — judul + meta (tanggal, kategori, penulis) → cover → isi → berita terkait → share WA.

**Agenda** — Hero kecil → daftar/kalender (tanggal pakai timezone sekolah).

**Galeri** — Hero kecil → filter kategori → masonry rasio seragam → lightbox → paginasi.

**Kontak** — Hero kecil → split: peta embed | (alamat/jam/sosial + form Livewire anti-spam).

## 9. Halaman Sistem
- **404** — nada hangat, ilustrasi/ikon, ▸"Kembali ke Beranda" + kotak cari.
- **/cari** — input + hasil dari Berita & Halaman (judul/isi), paginasi link asli.
- **sitemap.xml** — auto dari route aktif + konten published (hormati modul mati).
- **robots.txt** — izinkan publik, blok `/kelola`.
- **Maintenance** (opsional) — saat deploy, halaman sederhana berlogo.

## 10. Checklist Struktur (per build)
- [ ] Route modul mati = 404 (tidak terdaftar), bukan halaman kosong.
- [ ] Item menu & footer mengikuti `modul_aktif`.
- [ ] Dropdown kosong otomatis hilang.
- [ ] PPDB terlihat di header + tombol aksen.
- [ ] Breadcrumb di semua halaman non-Beranda + Schema.org.
- [ ] Sub-profil Kerohanian ikut modul keagamaan (atau jadi "Karakter & Nilai").
- [ ] Section beranda menyesuaikan modul aktif.
- [ ] sitemap.xml hanya memuat route & konten aktif/published.
- [ ] `/kelola` diblok di robots.txt.
- [ ] Mode menu (grouped/flat) berfungsi.

---

*Perubahan IA diperbarui di sini lebih dulu, baru di kode. Visual → `desain.md`, teknis → `arsitektur.md`.*
