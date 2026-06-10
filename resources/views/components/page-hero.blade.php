@props(['judul', 'induk' => null, 'indukUrl' => null])
<section class="hero-bg relative overflow-hidden text-white">
    <div class="absolute inset-0 dot-grid opacity-50"></div>
    <span class="blob bg-accent-500 w-56 h-56 -top-16 right-10"></span>
    <div class="container-page relative py-12 lg:py-16">
        <nav class="text-sm text-white/65 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            @if($induk) <span class="mx-1">/</span> <a href="{{ $indukUrl ?? '#' }}" class="hover:text-white">{{ $induk }}</a>@endif
            <span class="mx-1">/</span> <span class="text-white">{{ $judul }}</span>
        </nav>
        <h1 class="text-3xl text-white">{{ $judul }}</h1>
        <span class="accent-rule mt-4"></span>
    </div>
</section>
