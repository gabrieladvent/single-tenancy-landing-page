@extends('layouts.public')
@section('title', 'Galeri')

@php($fotos = $galeri->flatMap(fn ($g) => collect($g->fotoUrls())->map(fn ($u) => ['url' => $u, 'judul' => $g->judul])))

@section('content')
    <x-page-hero judul="Galeri" />
    <section class="container-page py-16" x-data="{ open:false, src:'' }">
        @if($fotos->isEmpty())
            <p class="text-ink-soft">Belum ada foto di galeri.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($fotos as $f)
                    <button type="button" @click="src='{{ $f['url'] }}'; open=true"
                            class="aspect-square overflow-hidden rounded-[var(--radius-pack)] bg-brand-100 group">
                        <img src="{{ $f['url'] }}" alt="{{ $f['judul'] }}" loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                    </button>
                @endforeach
            </div>

            {{-- Lightbox --}}
            <div x-show="open" x-cloak @keydown.escape.window="open=false"
                 x-transition.opacity
                 class="fixed inset-0 z-[400] bg-black/80 grid place-items-center p-6" @click="open=false">
                <img :src="src" class="max-h-[90vh] max-w-full rounded-[var(--radius-pack)]" alt="">
            </div>
        @endif
    </section>
@endsection
