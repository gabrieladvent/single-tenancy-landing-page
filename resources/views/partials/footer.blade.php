@inject('school', \App\Settings\SchoolSettings::class)
@php($modul = $school->modul_aktif ?? [])
<footer class="bg-brand-900 text-white/80 mt-20">
    <div class="container-page py-16 grid gap-10 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="font-[family-name:var(--font-heading)] text-lg text-white">{{ $school->nama_lengkap }}</div>
            <p class="mt-3 text-sm">{{ $school->moto }}</p>
        </div>

        <div>
            <h2 class="text-white font-medium mb-3 text-sm">Profil</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('profil.show', 'sejarah') }}" class="hover:text-white">Sejarah</a></li>
                <li><a href="{{ route('profil.show', 'visi-misi') }}" class="hover:text-white">Visi &amp; Misi</a></li>
                <li><a href="{{ route('profil.show', 'sambutan-kepala-sekolah') }}" class="hover:text-white">Sambutan Kepsek</a></li>
                <li><a href="{{ route('ppdb') }}" class="hover:text-white">PPDB</a></li>
            </ul>
        </div>

        <div>
            <h2 class="text-white font-medium mb-3 text-sm">Informasi</h2>
            <ul class="space-y-2 text-sm">
                @if($modul['berita'] ?? false)<li><a href="{{ route('berita.index') }}" class="hover:text-white">Berita</a></li>@endif
                <li><a href="{{ route('guru.index') }}" class="hover:text-white">Guru &amp; Tendik</a></li>
                <li><a href="{{ route('fasilitas.index') }}" class="hover:text-white">Fasilitas</a></li>
                <li><a href="{{ route('kontak') }}" class="hover:text-white">Kontak</a></li>
            </ul>
        </div>

        <div>
            <h2 class="text-white font-medium mb-3 text-sm">Terhubung</h2>
            <ul class="space-y-2 text-sm">
                @if($school->alamat)<li>{{ $school->alamat }}</li>@endif
                <li>{{ $school->jam_layanan }}</li>
                @if($school->telepon)<li>Telp: {{ $school->telepon }}</li>@endif
                @if($school->email)<li>{{ $school->email }}</li>@endif
            </ul>
            <div class="flex gap-2 mt-4">
                @if($school->instagram)<a href="{{ $school->instagram }}" aria-label="Instagram" class="grid place-items-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 transition"><x-ico name="instagram" class="w-4 h-4" /></a>@endif
                @if($school->youtube)<a href="{{ $school->youtube }}" aria-label="YouTube" class="grid place-items-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 transition"><x-ico name="youtube" class="w-4 h-4" /></a>@endif
                @if($school->facebook)<a href="{{ $school->facebook }}" aria-label="Facebook" class="grid place-items-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 transition"><x-ico name="facebook" class="w-4 h-4" /></a>@endif
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-page py-5 flex flex-col sm:flex-row gap-2 justify-between text-xs">
            <span>© {{ date('Y') }} {{ $school->nama_lengkap }}</span>
            <span>{{ $school->moto }}</span>
        </div>
    </div>
</footer>
