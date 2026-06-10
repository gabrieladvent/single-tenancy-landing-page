@extends('layouts.public')
@inject('school', \App\Settings\SchoolSettings::class)
@section('title', 'PPDB')

@section('content')
    <x-page-hero judul="Penerimaan Peserta Didik Baru" />
    <section class="container-page py-16">
        <x-section-heading label="Informasi" judul="Alur Pendaftaran" />
        <ol class="grid md:grid-cols-4 gap-6 mb-12">
            @foreach(['Daftar', 'Lengkapi Berkas', 'Seleksi', 'Pengumuman'] as $i => $step)
                <li class="bg-surface rounded-[var(--radius-pack)] border border-line p-6">
                    <div class="font-[family-name:var(--font-heading)] text-2xl text-accent-500">{{ $i+1 }}</div>
                    <div class="mt-2 font-medium">{{ $step }}</div>
                </li>
            @endforeach
        </ol>

        <div class="bg-brand-100 rounded-[var(--radius-pack)] p-8 text-center">
            <h3 class="text-xl">Siap mendaftar?</h3>
            <p class="text-ink-soft mt-2">Klik tombol di bawah untuk melanjutkan pendaftaran.</p>
            <a href="{{ $school->ppdb_link ?: '#' }}" @if($school->ppdb_link) target="_blank" rel="noopener" @endif
               class="inline-flex mt-5 px-6 py-3 rounded-[var(--radius-pack)] bg-accent-500 text-ink font-medium hover:bg-accent-600 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>
@endsection
