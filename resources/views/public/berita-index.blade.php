@extends('layouts.public')
@section('title', 'Berita')

@section('content')
    <x-page-hero judul="Berita Sekolah" />
    <section class="container-page py-16">
        @if($berita->isEmpty())
            <p class="text-ink-soft">Belum ada berita untuk saat ini.</p>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($berita as $b)
                    <a href="{{ route('berita.show', $b->slug) }}" class="bg-surface rounded-[var(--radius-pack)] border border-line overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition block">
                        <div class="aspect-[16/10] bg-brand-50">
                            @if($b->coverUrl())<img src="{{ $b->coverUrl() }}" alt="{{ $b->judul }}" class="w-full h-full object-cover">@endif
                        </div>
                        <div class="p-5">
                            @if($b->kategori)<span class="section-label">{{ $b->kategori }}</span>@endif
                            <h3 class="text-lg mt-1">{{ $b->judul }}</h3>
                            <div class="text-sm text-ink-soft mt-1">{{ $b->tanggal->translatedFormat('d F Y') }}</div>
                            <p class="text-ink-soft text-sm mt-2 line-clamp-2">{{ $b->ringkasan }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $berita->links() }}</div>
        @endif
    </section>
@endsection
