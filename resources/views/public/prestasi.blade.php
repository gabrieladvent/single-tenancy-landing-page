@extends('layouts.public')
@section('title', 'Prestasi')

@section('content')
    <x-page-hero judul="Prestasi" />
    <section class="container-page py-16">
        @if($prestasi->isEmpty())
            <p class="text-ink-soft">Belum ada data prestasi.</p>
        @else
            <div class="space-y-4 max-w-3xl">
                @foreach($prestasi as $p)
                    <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-5 flex items-start gap-4 shadow-sm">
                        <div class="font-[family-name:var(--font-heading)] text-2xl text-accent-500 shrink-0 w-20">{{ $p->tahun }}</div>
                        <div>
                            <h3 class="text-lg">{{ $p->nama }}</h3>
                            <div class="text-sm text-ink-soft mt-1">
                                @if($p->lomba){{ $p->lomba }}@endif
                                @if($p->peringkat) · <span class="text-brand-700 font-medium">{{ $p->peringkat }}</span>@endif
                                @if($p->tingkat) · {{ $p->tingkat }}@endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
