# Dokumen Desain — Website Sekolah (Sistem Visual)

> **Sumber kebenaran tampilan.** Template **reusable, single-tenant** (1 deploy = 1 sekolah). Sekolah baru = deploy salinan + atur tema/logo/konten lewat Settings. Tujuan visual: tiap sekolah terlihat **berkarakter, bukan template generik**, walau berbagi kerangka sama.
>
> Dokumen ini **hanya membahas sistem visual (desain).** Arsitektur, model data, dan implementasi ada di **`arsitektur.md`**. Menu/sitemap detail di **`struktur.md`** (menyusul).

| Meta | Nilai |
|------|-------|
| Versi | 0.7 |
| Tanggal | 2026-06-10 |
| Status | Draf — sistem visual stabil, brand per-sekolah menyusul |
| Lihat juga | `arsitektur.md`, `struktur.md` |

**Changelog**
- 0.7 — Tambah komponen cookie consent banner (selaras Analytics di `arsitektur.md`).
- 0.6 — Selaras dengan keputusan **single-tenant** (1 deploy/sekolah). Istilah "per-tenant" → "per-sekolah".
- 0.5 — Pisah dari arsitektur (file `arsitektur.md` terpisah). Tambah catatan plafon keragaman & aksen-dari-logo.
- 0.4 — Kunci stack & multi-tenant; tambah arsitektur (kini dipindah).
- 0.3 — Jadi template reusable: konfigurasi, modul keagamaan, sistem tema.
- 0.2 — Detail color/layout/konten/aksesibilitas. 0.1 — Draf awal.

---

## 1. Filosofi & Prinsip

Website sekolah terasa "template" karena: tak ada sistem (tiap halaman beda tipis), komponen default (slider auto-play, 3 kotak seragam), dan tanpa karakter (tak ada elemen khas berulang).

**Strategi:** kerangka sama, **karakter per sekolah lahir dari lapisan tema** (style pack + warna + logo + foto). Yang dikunci menjaga sinkronisasi; yang terbuka memberi identitas.

**Prinsip:**
- Konsisten > dekoratif. Ragu → samakan halaman lain.
- Identitas dari lapisan tema, bukan hiasan tambahan.
- 1 warna utama + 1 aksen + netral.
- Mobile-first (mayoritas pengunjung dari HP).
- Tiap elemen ada alasannya.

> **Plafon keragaman (jujur).** Style pack (3) + warna + logo + varian hero membuat sekolah tampak berbeda, **tapi ada batasnya**: banyak sekolah yang memakai template ini tetap terasa berkerabat. Janji "berkarakter" itu nyata namun **tidak mutlak** — diferensiasi terbesar tetap dari **foto asli & konten sekolah**, bukan dari token.

## 2. Theming Surface — yang DIKUNCI vs yang TERBUKA

Kunci agar tiap sekolah punya identitas **tanpa** merusak sinkronisasi internal. (Single-tenant: diatur sekali per deploy via Settings, tapi tetap bisa diubah admin.)

| Lapisan | Token | Bisa diubah admin? |
|--------|-------|--------------------|
| **Brand (terbuka)** | `--brand-*`, `--accent-*`, logo, foto, nama, moto | ✅ via Settings |
| **Style pack (terbuka, terbatas)** | `--font-heading`, `--font-body`, `--radius-*`, bentuk aksen | ✅ pilih 1 dari 3 |
| **Sistem (dikunci)** | skala spasi, skala tipografi, grid, breakpoint, durasi motion, pola komponen | ❌ sama untuk semua |

### Style Pack (pilih di Settings)

| Pack | Heading | Body | Radius | Bentuk aksen | Kesan |
|------|---------|------|--------|--------------|-------|
| `klasik` | Fraunces (serif) | Plus Jakarta Sans | md 12 | garis lurus | akademik, formal |
| `modern` | Plus Jakarta Sans bold | Inter | sm 6 | blok pendek | bersih, korporat |
| `hangat` | Lora (serif) | Nunito Sans | lg 20 | titik/dot | ramah, anak-friendly |

Style pack menukar **tipografi + radius + bentuk aksen sekaligus** — bukan cuma warna. Tetap **2 keluarga font** per pack.

## 3. Sistem Tema & Warna

Struktur selalu **1 utama + 1 aksen + netral**.

### Preset (kontras terverifikasi — pilih di Settings)

| Preset | brand-500 | accent-500 | Teks di brand-500 |
|--------|-----------|------------|-------------------|
| biru-akademik | `#2E5AAC` | `#E4B23C` | putih 5.9:1 ✅ |
| hijau-tumbuh | `#2F8F6B` | `#E4B23C` | putih 4.7:1 ✅ |
| marun-klasik | `#8C2F39` | `#D6A24E` | putih 7.1:1 ✅ |
| tosca-modern | `#1F8A8A` | `#F2A65A` | putih 4.6:1 ✅ |

Aksen selalu pakai teks `--ink` (emas/oranye gagal kontras dengan putih).

### Aksen dari logo
Jika admin hanya memberi **satu** warna brand (dari logo), aksen **tidak** ditebak otomatis — admin **memilih aksen** dari daftar emas/oranye aman di atas, atau pakai aksen preset. Ramp `brand-50..900` di-generate dari satu hex (algoritma di `arsitektur.md`). **Kontras dicek saat simpan** (lihat `arsitektur.md` B-validasi).

### Token Warna (struktur tetap)
```
brand : 900 700 500(utama) 400 200 100 50
accent: 600 500 100
netral: --ink #1A1D23 · --ink-soft #5A5F6B · --ink-faint #8A8F99
        --line #E3E6EB · --line-soft #EEF0F3 · --surface #FFF · --canvas #F7F8FA
        --overlay rgba(18,28,52,.55)
status: --success #2E7D5B · --error #C0392B · --warning #B7791F
```

### State interaktif
| Elemen | Default | Hover | Active | Focus |
|--------|---------|-------|--------|-------|
| Tombol primer | brand-500 | brand-700 | brand-900 | ring 3px brand-200 |
| Tombol aksen | accent-500 | accent-600 | dim | ring 3px accent-100 |
| Link | brand-500 | brand-700 + underline | brand-900 | ring 2px brand-200 |

### Aturan
Aksen **maks 1 per layar**. Paragraf selalu ink/ink-soft. Background section selang-seling `canvas`↔`brand-100`. Footer brand-900.

## 4. Tipografi
Skala (rasio 1.25): xs13 · sm14 · base16 (lh **1.7**) · lg20 · xl26 · 2xl32 · 3xl42 · 4xl52. Berat: heading 600/700, body 400, label 500. Lebar baca ≤65ch. Label uppercase: letter-spacing .08em, brand-500. **2 keluarga font per style pack.**

## 5. Logo
SVG + PNG; versi berwarna/putih/gelap. Min tinggi 32px (mobile)/40px (desktop). Clear space = tinggi elemen utama logo. Lockup header: logo + nama_singkat. **Larangan:** regang/miring/bayangan/ganti warna. **Placeholder:** monogram inisial dalam lingkaran brand-700 sampai logo asli ada. Favicon diturunkan dari logo.

## 6. Spasi, Radius, Bayangan, Z-index
- Spasi skala 4px: 1=4 … 6=24 … 16=64 20=80 24=96 32=128. Antar-section **96px desktop / 64px mobile**. Padding kartu **24px**. Judul→isi 32px.
- Radius dari style pack (sm6/md12/lg20). Full 999.
- Shadow: sm `0 1px 2px /.06` · md `0 4px 16px /.08` · lg `0 12px 32px /.12`.
- Z: dropdown100 · sticky200 · overlay300 · modal400 · toast500.

## 7. Layout & Grid
Breakpoint **768 / 1024 / 1280**. Max konten 1200px (xl) / 1120px (lg). Padding 20/32/40. Gutter 24px. Ritme pita: Header(72px sticky) → Hero → canvas → brand-100 → canvas → CTA band(brand-700) → Footer(brand-900). Anti-template: hero asimetris 7/5, berita 1 besar+2 kecil, statistik band.

## 8. Komponen (pola dikunci, ditema via token)

- **Hero — 2 varian resmi, pilih satu per sekolah:** (A) split asimetris, teks di samping foto, tanpa overlay; (B) full-bleed, teks di atas foto + `--overlay` (≥4.5:1). Jangan campur.
- **Header** 72/64px sticky, lockup kiri, menu kanan; scroll>40px→shadow; <1024px hamburger drawer.
- **Tombol:** primer(brand) / aksen(accent — **1 CTA terpenting**) / sekunder(border) / ghost. Padding 12×24, radius pack, 500. Disabled .5, loading spinner.
- **Kartu:** surface, radius pack, border line, padding 24, shadow-sm; hover shadow-md + translateY(-2px).
- **Judul section (pola wajib — tanda tangan #2):** LABEL UPPERCASE brand-500 → Judul serif 2xl → garis/bentuk aksen 48px. Di **setiap** section.
- **Footer** brand-900, 4 kolom (alamat/jam · link · profil/ppdb · sosial) + moto.
- **Empty/error:** berita kosong→ikon+pesan; form gagal→toast; 404 hangat.
- **Cookie consent banner** (jika analytics aktif): pita bawah, `surface` + border-top `--line`, teks `ink-soft` text-sm, tombol primer "Setuju" + ghost "Tolak". Tidak menutupi konten, dapat ditutup, muncul sekali (disimpan di localStorage).
- Accordion · breadcrumb · stepper · tab/filter · lightbox · pagination · toast · badge — semua ikut token.

## 9. Form & Input
44px, radius pack, border line. Focus ring brand-200. Label **di atas** input. Error border `--error` + pesan. Sukses toast. Submit full-width mobile. Validasi inline (blur).

## 10. Ikonografi & Foto
Ikon: **satu set** (Lucide), outline 1.5px, 20/24px, warna ink-soft/brand-500. Foto: rasio seragam per konteks (hero 4:3, berita 16:10, guru 1:1), treatment seragam (hangat, +5% saturasi), WebP/AVIF, lazy non-hero, `alt`. **Foto asli sekolah > stok** (pembeda terbesar — lihat plafon §1).

## 11. Elemen Khas (per style pack — tanda tangan)
1. Garis/bentuk aksen 48px di bawah judul section (lurus/blok/dot ikut pack).
2. Pasangan serif/sans (heading/body).
3. Angka statistik serif aksen besar di band brand.
Opsional: motif khas sekolah disederhanakan jadi pembatas. **Maksimal segini** — jangan banyak gimmick.

## 12. Motion
Hover **150ms ease-out** (seragam). Dropdown/drawer 200ms. Scroll reveal: fade + naik 12px, 400ms, sekali. **Dilarang:** auto-play cepat, kedip, parallax berlebih. Hormati `prefers-reduced-motion`.

## 13. Responsif
Mobile-first, patah 768/1024/1280. Grid 3→1 di bawah 768. Hero 4xl→2xl. Header→hamburger <1024. Target sentuh ≥44px. Tabel→scroll/kartu.

## 14. Aksesibilitas (WCAG 2.1 AA)
Kontras ≥4.5:1 (besar ≥3:1). Skip-to-content. Fokus keyboard terlihat + urut. `alt` tiap gambar (dekoratif `alt=""`). Satu h1, heading urut. Label tiap input. `lang="id"`. **Verifikasi tiap style pack + preset.** (Cek kontras otomatis saat admin simpan warna → `arsitektur.md`.)

---

## 15. Checklist Sinkronisasi Visual (per halaman)

- [ ] Warna/font/radius dari token style-pack + tema — **tak ada nilai manual**.
- [ ] Antar-section 96px desktop. Background selang-seling canvas/brand-100.
- [ ] Judul serif, body sans — tanpa pengecualian.
- [ ] Tiap section: label + judul serif + aksen 48px.
- [ ] Aksen **maks 1 per layar**. Kartu radius pack + padding 24.
- [ ] Hover & transisi 150ms. Foto rasio & treatment seragam.
- [ ] Hero satu varian konsisten. Logo penuhi aturan §5.
- [ ] Kontras ≥4.5:1. Skip-to-content + fokus terlihat.
- [ ] Tak ada komponen baru di luar §8.
- [ ] Diuji di HP (mobile-first).

---

*Perubahan visual diperbarui di sini lebih dulu, baru di kode. Arsitektur & teknis → `arsitektur.md`.*
