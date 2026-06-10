@extends('layouts.public')
@inject('school', \App\Settings\SchoolSettings::class)
@php($modul = $school->modul_aktif ?? [])

@section('content')
    {{-- HERO full-bleed gradien + dekorasi --}}
    <section class="hero-bg relative overflow-hidden text-white">
        @if($school->hero_image)
            <img src="{{ asset('storage/'.$school->hero_image) }}" alt="" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0" style="background: var(--overlay)"></div>
        @endif
        <div class="absolute inset-0 dot-grid opacity-60"></div>
        <span class="blob bg-accent-500 w-72 h-72 -top-16 -right-10"></span>
        <span class="blob w-72 h-72 bottom-0 left-1/4" style="background: var(--brand-400)"></span>

        <div class="container-page relative py-20 lg:py-28 grid lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7">
                <span class="inline-flex items-center gap-2 text-xs font-medium tracking-wider uppercase text-accent-500 bg-white/10 px-3 py-1 rounded-full">{{ $school->jenjang }} {{ $school->status }} · {{ $school->akreditasi ? 'Akreditasi '.$school->akreditasi : 'Selamat Datang' }}</span>
                <h1 class="text-3xl lg:text-4xl mt-5 leading-tight text-white">{{ $school->moto }}</h1>
                <p class="mt-5 text-lg text-white/80 max-w-[58ch]">
                    {{ $school->nama_lengkap }} membentuk siswa unggul dalam akademik dan karakter.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('ppdb') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-[var(--radius-pack)] bg-accent-500 text-ink font-medium hover:bg-accent-600 hover:-translate-y-0.5 shadow-lg transition">Daftar PPDB <x-ico name="arrow-right" class="w-4 h-4" /></a>
                    <a href="{{ route('profil.show', 'sejarah') }}" class="inline-flex items-center px-6 py-3 rounded-[var(--radius-pack)] border border-white/30 text-white font-medium hover:bg-white/10 transition">Profil Sekolah</a>
                </div>
            </div>

            {{-- Visual kanan: monogram berbingkai + aksen --}}
            <div class="lg:col-span-5 hidden lg:block">
                <div class="relative mx-auto w-full max-w-sm">
                    <div class="absolute -inset-3 rounded-[2rem] bg-white/10"></div>
                    <div class="relative aspect-[4/5] rounded-[1.6rem] bg-white/10 backdrop-blur-sm border border-white/15 grid place-items-center overflow-hidden">
                        @if($school->logo)
                            <img src="{{ asset('storage/'.$school->logo) }}" alt="Logo" class="w-40 h-40 object-contain">
                        @else
                            <span class="font-[family-name:var(--font-heading)] text-7xl text-white/90">{{ \Illuminate\Support\Str::of($school->nama_singkat)->explode(' ')->take(2)->map(fn($w)=>mb_substr($w,0,1))->implode('') }}</span>
                        @endif
                    </div>
                    <div class="absolute -bottom-5 -left-5 bg-surface text-ink rounded-[var(--radius-pack)] shadow-lg px-5 py-3">
                        <div class="font-[family-name:var(--font-heading)] text-2xl text-brand-700">{{ $school->nama_singkat }}</div>
                        <div class="text-xs text-ink-soft">Buka Pikiran · Sentuh Hati</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STRIP INFO (overlap hero) --}}
    <section class="container-page relative z-10 -mt-10">
        <div class="grid sm:grid-cols-3 gap-4">
            @php($infos = [
                ['icon'=>'cap','judul'=>'PPDB Dibuka','teks'=>'Bergabung tahun ajaran baru','url'=>route('ppdb')],
                ['icon'=>'clock','judul'=>'Jam Layanan','teks'=>$school->jam_layanan,'url'=>route('kontak')],
                ['icon'=>'map-pin','judul'=>'Lokasi','teks'=>\Illuminate\Support\Str::limit($school->alamat ?: 'Lihat lokasi kami', 40),'url'=>route('kontak')],
            ])
            @foreach($infos as $i)
                <a href="{{ $i['url'] }}" class="bg-surface rounded-[var(--radius-pack)] border border-line shadow-sm hover:shadow-md hover:-translate-y-0.5 transition p-5 flex items-start gap-4">
                    <span class="icon-badge shrink-0"><x-ico name="{{ $i['icon'] }}" /></span>
                    <span>
                        <span class="block font-medium text-ink">{{ $i['judul'] }}</span>
                        <span class="block text-sm text-ink-soft mt-0.5">{{ $i['teks'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- SAMBUTAN --}}
    @if($sambutan)
    <section class="container-page py-16 lg:py-24 grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-5">
            <div class="relative">
                <div class="aspect-[4/5] rounded-[var(--radius-pack)] media-placeholder grid place-items-center overflow-hidden">
                    <x-ico name="users" class="w-16 h-16 opacity-40" />
                </div>
                <span class="absolute -top-4 -left-4 icon-badge w-12 h-12 bg-accent-500 text-ink shadow-lg"><x-ico name="quote" class="w-6 h-6" /></span>
            </div>
        </div>
        <div class="lg:col-span-7">
            <x-section-heading label="Sambutan" judul="Kepala Sekolah" />
            <p class="text-ink-soft leading-relaxed text-lg">{{ \Illuminate\Support\Str::limit(strip_tags($sambutan->konten), 500) }}</p>
            <a href="{{ route('profil.show', 'sambutan-kepala-sekolah') }}" class="inline-flex items-center gap-1.5 mt-5 text-brand-500 font-medium hover:text-brand-700">Baca selengkapnya <x-ico name="arrow-right" class="w-4 h-4" /></a>
        </div>
    </section>
    @endif

    {{-- STATISTIK --}}
    @if($statistik->isNotEmpty())
    <section class="hero-bg relative overflow-hidden text-white">
        <div class="absolute inset-0 dot-grid opacity-50"></div>
        <div class="container-page relative py-14 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            @foreach($statistik as $s)
                <div>
                    <div class="font-[family-name:var(--font-heading)] text-4xl text-accent-500">{{ $s->angka }}</div>
                    <div class="text-sm text-white/70 mt-1">{{ $s->label }}</div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- KEUNGGULAN (kartu berikon) --}}
    <section class="container-page py-16 lg:py-24">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="section-label">Mengapa kami</span>
            <h2 class="text-2xl mt-2">Keunggulan Sekolah</h2>
            <span class="accent-rule mt-4 mx-auto"></span>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php($keunggulan = [
                ['icon'=>'cap','judul'=>'Akademik','teks'=>'Pembelajaran berkualitas dengan guru berpengalaman dan kurikulum terkini.'],
                ['icon'=>'heart','judul'=>'Karakter','teks'=>'Pembentukan disiplin, tanggung jawab, dan kepedulian dalam keseharian.'],
                ['icon'=>'sparkles','judul'=>'Kerohanian','teks'=>'Penguatan iman dan nilai-nilai luhur sebagai fondasi hidup.'],
            ])
            @foreach($keunggulan as $k)
                <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-7 shadow-sm hover:shadow-md hover:-translate-y-1 transition">
                    <span class="icon-badge"><x-ico name="{{ $k['icon'] }}" class="w-6 h-6" /></span>
                    <h3 class="text-xl mt-5">{{ $k['judul'] }}</h3>
                    <p class="mt-2 text-ink-soft">{{ $k['teks'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- VISI & MISI --}}
    @if($visiMisi)
    <section class="bg-brand-100 dot-grid-ink">
        <div class="container-page py-16 lg:py-24 grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <x-section-heading label="Arah kami" judul="Visi & Misi" />
                <a href="{{ route('profil.show', 'visi-misi') }}" class="inline-flex items-center gap-1.5 text-brand-500 font-medium hover:text-brand-700">Selengkapnya <x-ico name="arrow-right" class="w-4 h-4" /></a>
            </div>
            <div class="lg:col-span-8 prose prose-neutral max-w-none text-ink-soft leading-relaxed bg-surface rounded-[var(--radius-pack)] border border-line p-8 shadow-sm">
                {!! \Illuminate\Support\Str::limit(strip_tags($visiMisi->konten), 700) ?: 'Konten visi &amp; misi dapat diisi melalui panel admin.' !!}
            </div>
        </div>
    </section>
    @endif

    {{-- BERITA (1 unggulan + 2) --}}
    @if(($modul['berita'] ?? false) && $berita->isNotEmpty())
    <section class="container-page py-16 lg:py-24">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="section-label">Kabar terbaru</span>
                <h2 class="text-2xl mt-2">Berita Sekolah</h2>
                <span class="accent-rule mt-4"></span>
            </div>
            <a href="{{ route('berita.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-brand-500 font-medium hover:text-brand-700">Semua berita <x-ico name="arrow-right" class="w-4 h-4" /></a>
        </div>
        <div class="grid lg:grid-cols-12 gap-6">
            @php($utama = $berita->first())
            <a href="{{ route('berita.show', $utama->slug) }}" class="lg:col-span-7 group bg-surface rounded-[var(--radius-pack)] border border-line overflow-hidden shadow-sm hover:shadow-md transition block">
                <div class="aspect-[16/10] media-placeholder grid place-items-center overflow-hidden">
                    @if($utama->coverUrl())<img src="{{ $utama->coverUrl() }}" alt="{{ $utama->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">@else<x-ico name="newspaper" class="w-14 h-14 opacity-40" />@endif
                </div>
                <div class="p-6">
                    @if($utama->kategori)<span class="section-label">{{ $utama->kategori }}</span>@endif
                    <h3 class="text-xl mt-1">{{ $utama->judul }}</h3>
                    <div class="text-sm text-ink-soft mt-1 flex items-center gap-1.5"><x-ico name="calendar" class="w-3.5 h-3.5" /> {{ $utama->tanggal->translatedFormat('d F Y') }}</div>
                    <p class="text-ink-soft mt-3 line-clamp-2">{{ $utama->ringkasan }}</p>
                </div>
            </a>
            <div class="lg:col-span-5 grid gap-6">
                @foreach($berita->skip(1)->take(2) as $b)
                    <a href="{{ route('berita.show', $b->slug) }}" class="group bg-surface rounded-[var(--radius-pack)] border border-line overflow-hidden shadow-sm hover:shadow-md transition flex">
                        <div class="w-28 shrink-0 media-placeholder grid place-items-center">
                            @if($b->coverUrl())<img src="{{ $b->coverUrl() }}" alt="{{ $b->judul }}" class="w-full h-full object-cover">@else<x-ico name="newspaper" class="w-7 h-7 opacity-40" />@endif
                        </div>
                        <div class="p-4">
                            @if($b->kategori)<span class="section-label">{{ $b->kategori }}</span>@endif
                            <h3 class="text-base mt-0.5 leading-snug line-clamp-2">{{ $b->judul }}</h3>
                            <div class="text-xs text-ink-soft mt-1">{{ $b->tanggal->translatedFormat('d M Y') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- PRESTASI --}}
    @if(($modul['prestasi'] ?? false) && $prestasi->isNotEmpty())
    <section class="bg-brand-100 dot-grid-ink">
        <div class="container-page py-16 lg:py-24">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="section-label">Membanggakan</span>
                <h2 class="text-2xl mt-2">Prestasi Terbaru</h2>
                <span class="accent-rule mt-4 mx-auto"></span>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($prestasi as $p)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-6 shadow-sm hover:shadow-md transition">
                        <span class="icon-badge bg-accent-100 text-accent-600"><x-ico name="trophy" class="w-6 h-6" /></span>
                        <div class="font-[family-name:var(--font-heading)] text-2xl text-brand-700 mt-4">{{ $p->tahun }}</div>
                        <h3 class="text-base mt-1 leading-snug">{{ $p->nama }}</h3>
                        <div class="text-sm text-ink-soft mt-1">{{ $p->peringkat }}@if($p->tingkat) · {{ $p->tingkat }}@endif</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA band --}}
    <section class="hero-bg relative overflow-hidden text-white">
        <div class="absolute inset-0 dot-grid opacity-50"></div>
        <span class="blob bg-accent-500 w-64 h-64 -bottom-20 right-10"></span>
        <div class="container-page relative py-16 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl text-white">Bergabung tahun ajaran ini?</h2>
                <p class="text-white/75 mt-1">Informasi penerimaan peserta didik baru telah dibuka.</p>
            </div>
            <a href="{{ route('ppdb') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-[var(--radius-pack)] bg-accent-500 text-ink font-medium hover:bg-accent-600 hover:-translate-y-0.5 shadow-lg transition shrink-0">Daftar PPDB <x-ico name="arrow-right" class="w-4 h-4" /></a>
        </div>
    </section>
@endsection
