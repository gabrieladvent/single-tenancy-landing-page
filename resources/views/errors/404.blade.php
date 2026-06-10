@extends('layouts.public')
@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <section class="container-page py-24 lg:py-32 text-center">
        <div class="font-[family-name:var(--font-heading)] text-7xl lg:text-8xl text-brand-200">404</div>
        <h1 class="text-2xl mt-4">Halaman tidak ditemukan</h1>
        <p class="text-ink-soft mt-3 max-w-md mx-auto">Maaf, halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
        <div class="mt-8 flex flex-wrap gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-[var(--radius-pack)] bg-brand-500 text-white font-medium hover:bg-brand-700 transition">
                <x-ico name="arrow-right" class="w-4 h-4 rotate-180" /> Kembali ke Beranda
            </a>
            <a href="{{ route('kontak') }}" class="inline-flex items-center px-6 py-3 rounded-[var(--radius-pack)] border border-brand-500 text-brand-500 font-medium hover:bg-brand-50 transition">Hubungi Kami</a>
        </div>
    </section>
@endsection
