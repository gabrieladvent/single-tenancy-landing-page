@inject('school', \App\Settings\SchoolSettings::class)
@php($modul = $school->modul_aktif ?? [])
<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 40"
    :class="scrolled ? 'shadow-sm' : ''"
    class="sticky top-0 z-[200] bg-surface border-b border-line transition-shadow duration-200"
>
    <div class="container-page flex items-center justify-between h-16 lg:h-[72px]">
        {{-- Logo lockup --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            @if($school->logo)
                <img src="{{ asset('storage/'.$school->logo) }}" alt="Logo {{ $school->nama_singkat }}" class="h-9 lg:h-10 w-auto transition-transform duration-200 group-hover:scale-105">
            @else
                <span class="grid place-items-center h-9 w-9 lg:h-10 lg:w-10 rounded-full bg-brand-700 text-white font-[family-name:var(--font-heading)] text-sm transition-transform duration-200 group-hover:scale-105">
                    {{ \Illuminate\Support\Str::of($school->nama_singkat)->explode(' ')->take(2)->map(fn($w) => mb_substr($w,0,1))->implode('') }}
                </span>
            @endif
            <span class="font-[family-name:var(--font-heading)] text-lg text-brand-900 hidden sm:block">{{ $school->nama_singkat }}</span>
        </a>

        {{-- Menu desktop --}}
        <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" @class(['nav-link px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700']) @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>

            {{-- Profil (dropdown hover-intent) --}}
            <div
                class="relative"
                x-data="{ open:false, t:null, show(){ clearTimeout(this.t); this.open=true }, hide(){ this.t=setTimeout(()=>this.open=false, 220) } }"
                @mouseenter="show()" @mouseleave="hide()" @focusin="show()" @focusout="hide()"
            >
                <button
                    @click="open=!open"
                    class="nav-link inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700"
                    :aria-expanded="open"
                >
                    Profil
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transition-transform duration-200" :class="open && 'rotate-180'"><path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                {{-- top-full + pt-2 = jembatan tak terlihat, tanpa dead zone --}}
                <div
                    x-show="open" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full pt-2 w-60 origin-top"
                >
                    <div class="bg-surface rounded-[var(--radius-pack)] shadow-lg border border-line py-2">
                        <a href="{{ route('profil.show', 'sejarah') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Sejarah</a>
                        <a href="{{ route('profil.show', 'visi-misi') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Visi &amp; Misi</a>
                        <a href="{{ route('profil.show', 'sambutan-kepala-sekolah') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Sambutan Kepala Sekolah</a>
                        <a href="{{ route('profil.show', 'struktur-organisasi') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Struktur Organisasi</a>
                        @if($modul['keagamaan'] ?? false)
                            <a href="{{ route('profil.show', 'kerohanian') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Kerohanian</a>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('ppdb') }}" @class(['nav-link px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700']) @if(request()->routeIs('ppdb')) aria-current="page" @endif>PPDB</a>

            {{-- Akademik (dropdown hover-intent) --}}
            <div
                class="relative"
                x-data="{ open:false, t:null, show(){ clearTimeout(this.t); this.open=true }, hide(){ this.t=setTimeout(()=>this.open=false, 220) } }"
                @mouseenter="show()" @mouseleave="hide()" @focusin="show()" @focusout="hide()"
            >
                <button
                    @click="open=!open"
                    class="nav-link inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700"
                    :aria-expanded="open"
                >
                    Akademik
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transition-transform duration-200" :class="open && 'rotate-180'"><path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div
                    x-show="open" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full pt-2 w-52 origin-top"
                >
                    <div class="bg-surface rounded-[var(--radius-pack)] shadow-lg border border-line py-2">
                        <a href="{{ route('guru.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Guru &amp; Tendik</a>
                        <a href="{{ route('fasilitas.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Fasilitas</a>
                        @if($modul['ekstrakurikuler'] ?? false)
                            <a href="{{ route('ekskul.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Ekstrakurikuler</a>
                        @endif
                        @if($modul['prestasi'] ?? false)
                            <a href="{{ route('prestasi.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Prestasi</a>
                        @endif
                    </div>
                </div>
            </div>

            @if(($modul['berita'] ?? false) || ($modul['agenda'] ?? false) || ($modul['galeri'] ?? false))
            <div
                class="relative"
                x-data="{ open:false, t:null, show(){ clearTimeout(this.t); this.open=true }, hide(){ this.t=setTimeout(()=>this.open=false, 220) } }"
                @mouseenter="show()" @mouseleave="hide()" @focusin="show()" @focusout="hide()"
            >
                <button @click="open=!open" class="nav-link inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700" :aria-expanded="open">
                    Informasi
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transition-transform duration-200" :class="open && 'rotate-180'"><path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div x-show="open" x-cloak
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full pt-2 w-48 origin-top">
                    <div class="bg-surface rounded-[var(--radius-pack)] shadow-lg border border-line py-2">
                        @if($modul['berita'] ?? false)<a href="{{ route('berita.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Berita</a>@endif
                        @if($modul['agenda'] ?? false)<a href="{{ route('agenda.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Agenda</a>@endif
                        @if($modul['galeri'] ?? false)<a href="{{ route('galeri.index') }}" class="block px-4 py-2 text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-700 transition-colors">Galeri</a>@endif
                    </div>
                </div>
            </div>
            @endif

            <a href="{{ route('kontak') }}" @class(['nav-link px-3 py-2 text-sm font-medium text-ink-soft hover:text-brand-700']) @if(request()->routeIs('kontak')) aria-current="page" @endif>Kontak</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('ppdb') }}" class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-[var(--radius-pack)] bg-accent-500 text-ink text-sm font-medium hover:bg-accent-600 hover:-translate-y-0.5 shadow-sm hover:shadow-md transition duration-200">Daftar PPDB</a>
            <button @click="open = true" class="lg:hidden p-2 text-ink" aria-label="Buka menu">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
            </button>
        </div>
    </div>

    {{-- Drawer mobile --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-[300] lg:hidden">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-black/40" @click="open = false"
        ></div>
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-250" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-72 bg-surface p-6 overflow-y-auto shadow-lg"
        >
            <button @click="open = false" class="mb-6 text-ink-soft" aria-label="Tutup menu">✕</button>
            <nav class="flex flex-col gap-1" aria-label="Navigasi mobile">
                <a href="{{ route('home') }}" class="py-2 font-medium text-ink hover:text-brand-700 transition-colors">Beranda</a>
                <span class="pt-3 pb-1 section-label">Profil</span>
                <a href="{{ route('profil.show', 'sejarah') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Sejarah</a>
                <a href="{{ route('profil.show', 'visi-misi') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Visi &amp; Misi</a>
                <a href="{{ route('profil.show', 'sambutan-kepala-sekolah') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Sambutan Kepala Sekolah</a>
                <a href="{{ route('profil.show', 'struktur-organisasi') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Struktur Organisasi</a>
                @if($modul['keagamaan'] ?? false)
                    <a href="{{ route('profil.show', 'kerohanian') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Kerohanian</a>
                @endif
                <span class="pt-3 pb-1 section-label">Akademik</span>
                <a href="{{ route('guru.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Guru &amp; Tendik</a>
                <a href="{{ route('fasilitas.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Fasilitas</a>
                @if($modul['ekstrakurikuler'] ?? false)<a href="{{ route('ekskul.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Ekstrakurikuler</a>@endif
                @if($modul['prestasi'] ?? false)<a href="{{ route('prestasi.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Prestasi</a>@endif

                @if(($modul['berita'] ?? false) || ($modul['agenda'] ?? false) || ($modul['galeri'] ?? false))
                    <span class="pt-3 pb-1 section-label">Informasi</span>
                    @if($modul['berita'] ?? false)<a href="{{ route('berita.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Berita</a>@endif
                    @if($modul['agenda'] ?? false)<a href="{{ route('agenda.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Agenda</a>@endif
                    @if($modul['galeri'] ?? false)<a href="{{ route('galeri.index') }}" class="py-1.5 text-ink-soft hover:text-brand-700 transition-colors">Galeri</a>@endif
                @endif

                <a href="{{ route('kontak') }}" class="mt-2 py-2 font-medium text-ink hover:text-brand-700 transition-colors">Kontak</a>
                <a href="{{ route('ppdb') }}" class="mt-4 inline-flex justify-center px-5 py-2.5 rounded-[var(--radius-pack)] bg-accent-500 text-ink font-medium hover:bg-accent-600 transition">Daftar PPDB</a>
            </nav>
        </div>
    </div>
</header>
