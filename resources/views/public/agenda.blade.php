@extends('layouts.public')
@section('title', 'Agenda')

@section('content')
    <x-page-hero judul="Agenda Kegiatan" />
    <section class="container-page py-16">
        @if($agenda->isEmpty())
            <p class="text-ink-soft">Belum ada agenda.</p>
        @else
            <div class="space-y-4 max-w-3xl">
                @foreach($agenda as $a)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-5 flex items-start gap-5 shadow-sm">
                        <div class="text-center shrink-0 w-16">
                            <div class="font-[family-name:var(--font-heading)] text-2xl text-brand-700 leading-none">{{ $a->mulai->translatedFormat('d') }}</div>
                            <div class="text-xs text-ink-soft uppercase mt-1">{{ $a->mulai->translatedFormat('M Y') }}</div>
                        </div>
                        <div>
                            <h3 class="text-lg">{{ $a->judul }}</h3>
                            <div class="text-sm text-ink-soft mt-1">
                                🕒 {{ $a->mulai->translatedFormat('H:i') }}@if($a->selesai)–{{ $a->selesai->translatedFormat('H:i') }}@endif WIB
                                @if($a->lokasi) · 📍 {{ $a->lokasi }}@endif
                            </div>
                            @if($a->deskripsi)<p class="text-ink-soft text-sm mt-2">{{ $a->deskripsi }}</p>@endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
