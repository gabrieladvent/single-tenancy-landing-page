@extends('layouts.public')
@section('title', 'Ekstrakurikuler')

@section('content')
    <x-page-hero judul="Ekstrakurikuler" />
    <section class="container-page py-16">
        @if($ekskul->isEmpty())
            <p class="text-ink-soft">Belum ada data ekstrakurikuler.</p>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($ekskul as $e)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
                        <div class="aspect-[16/10] media-placeholder grid place-items-center">
                            @if($e->fotoUrl())<img src="{{ $e->fotoUrl() }}" alt="{{ $e->nama }}" class="w-full h-full object-cover">@else<x-ico name="sparkles" class="w-12 h-12 opacity-40" />@endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg">{{ $e->nama }}</h3>
                            @if($e->jadwal)<div class="text-sm text-ink-soft mt-1">🕒 {{ $e->jadwal }}</div>@endif
                            @if($e->pembina)<div class="text-sm text-ink-soft">👤 {{ $e->pembina }}</div>@endif
                            @if($e->deskripsi)<p class="text-ink-soft text-sm mt-2 line-clamp-3">{{ $e->deskripsi }}</p>@endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
