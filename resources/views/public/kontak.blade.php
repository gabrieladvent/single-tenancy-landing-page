@extends('layouts.public')
@inject('school', \App\Settings\SchoolSettings::class)
@section('title', 'Kontak')

@section('content')
    <x-page-hero judul="Kontak" />
    <section class="container-page py-16 grid lg:grid-cols-2 gap-10">
        <div>
            <x-section-heading label="Hubungi kami" judul="Informasi Kontak" />
            <ul class="space-y-3 text-ink-soft">
                @if($school->alamat)<li><strong class="text-ink">Alamat:</strong> {{ $school->alamat }}</li>@endif
                <li><strong class="text-ink">Jam:</strong> {{ $school->jam_layanan }}</li>
                @if($school->telepon)<li><strong class="text-ink">Telepon:</strong> {{ $school->telepon }}</li>@endif
                @if($school->whatsapp)<li><strong class="text-ink">WhatsApp:</strong> {{ $school->whatsapp }}</li>@endif
                @if($school->email)<li><strong class="text-ink">Email:</strong> {{ $school->email }}</li>@endif
            </ul>
            @if($school->peta_embed)
                <div class="mt-6 aspect-[16/9] rounded-[var(--radius-pack)] overflow-hidden">{!! $school->peta_embed !!}</div>
            @endif
        </div>

        <div class="bg-surface rounded-[var(--radius-pack)] border border-line p-6">
            @if(session('kontak_sukses'))
                <div class="mb-4 rounded p-3 text-sm" style="background:var(--success);color:#fff">{{ session('kontak_sukses') }}</div>
            @endif
            <form method="POST" action="{{ route('kontak.kirim') }}" class="space-y-4">
                @csrf
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off"> {{-- honeypot --}}
                <div>
                    <label class="block text-sm font-medium mb-1" for="nama">Nama</label>
                    <input id="nama" name="nama" required class="w-full h-11 rounded-[var(--radius-pack)] border border-line px-3">
                    @error('nama')<p class="text-sm mt-1" style="color:var(--error)">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="email">Email</label>
                    <input id="email" name="email" type="email" required class="w-full h-11 rounded-[var(--radius-pack)] border border-line px-3">
                    @error('email')<p class="text-sm mt-1" style="color:var(--error)">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="pesan">Pesan</label>
                    <textarea id="pesan" name="pesan" rows="4" required class="w-full rounded-[var(--radius-pack)] border border-line px-3 py-2"></textarea>
                    @error('pesan')<p class="text-sm mt-1" style="color:var(--error)">{{ $message }}</p>@enderror
                </div>
                <button class="w-full sm:w-auto px-6 py-3 rounded-[var(--radius-pack)] bg-brand-500 text-white font-medium hover:bg-brand-700 transition">Kirim Pesan</button>
            </form>
        </div>
    </section>
@endsection
