@extends('layouts.public')
@section('title', 'Guru & Tendik')

@section('content')
    <x-page-hero judul="Guru & Tenaga Kependidikan" />
    <section class="container-page py-16">
        @if($guru->isEmpty())
            <p class="text-ink-soft">Belum ada data guru.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($guru as $g)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-5 text-center shadow-sm">
                        <div class="aspect-square rounded-full overflow-hidden media-placeholder w-28 mx-auto mb-4 grid place-items-center">
                            @if($g->fotoUrl())<img src="{{ $g->fotoUrl() }}" alt="{{ $g->nama }}" class="w-full h-full object-cover">@else<x-ico name="users" class="w-10 h-10 opacity-40" />@endif
                        </div>
                        <h3 class="text-lg">{{ $g->nama }}</h3>
                        <div class="text-sm text-ink-soft">{{ $g->jabatan ?: $g->mapel }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
