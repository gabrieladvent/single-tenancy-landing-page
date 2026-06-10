@extends('layouts.public')
@section('title', $berita->judul)
@section('description', $berita->ringkasan)

@section('content')
    <x-page-hero :judul="$berita->judul" induk="Berita" :indukUrl="route('berita.index')" />
    <article class="container-page py-16 max-w-[70ch]">
        <div class="text-sm text-ink-soft mb-6">
            {{ $berita->tanggal->translatedFormat('d F Y') }}
            @if($berita->kategori) · {{ $berita->kategori }}@endif
        </div>
        @if($berita->coverUrl())
            <img src="{{ $berita->coverUrl() }}" alt="{{ $berita->judul }}" class="w-full rounded-[var(--radius-pack)] mb-8">
        @endif
        <div class="prose prose-neutral max-w-none text-ink-soft leading-relaxed">
            {!! $berita->isi ?: e($berita->ringkasan) !!}
        </div>
    </article>
@endsection
