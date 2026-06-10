@extends('layouts.public')

@section('title', $halaman->judul)

@section('content')
    <x-page-hero :judul="$halaman->judul" induk="Profil" :indukUrl="url('/profil/sejarah')" />
    <article class="container-page py-16 max-w-[70ch]">
        <div class="prose prose-neutral max-w-none text-ink-soft leading-relaxed">
            {!! $halaman->konten ?: '<p>Konten belum tersedia.</p>' !!}
        </div>
    </article>
@endsection
