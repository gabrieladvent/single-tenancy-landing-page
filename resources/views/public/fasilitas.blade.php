@extends('layouts.public')
@section('title', 'Fasilitas')

@section('content')
    <x-page-hero judul="Fasilitas Sekolah" />
    <section class="container-page py-16">
        @if($fasilitas->isEmpty())
            <p class="text-ink-soft">Belum ada data fasilitas.</p>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($fasilitas as $f)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line overflow-hidden shadow-sm">
                        <div class="aspect-[16/10] media-placeholder grid place-items-center">
                            @if($f->fotoUrl())<img src="{{ $f->fotoUrl() }}" alt="{{ $f->nama }}" class="w-full h-full object-cover">@else<x-ico name="building" class="w-12 h-12 opacity-40" />@endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg">{{ $f->nama }}</h3>
                            <p class="text-ink-soft text-sm mt-2">{{ $f->deskripsi }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
