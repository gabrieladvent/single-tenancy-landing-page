<?php

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Halaman;
use App\Models\PesanKontak;
use App\Models\Prestasi;
use App\Models\Statistik;
use App\Settings\SchoolSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home', [
        'statistik' => Statistik::orderBy('urutan')->get(),
        'berita' => Berita::published()->latest('tanggal')->take(3)->get(),
        'sambutan' => Halaman::published()->where('slug', 'sambutan-kepala-sekolah')->first(),
        'visiMisi' => Halaman::published()->where('slug', 'visi-misi')->first(),
        'prestasi' => Prestasi::orderByDesc('tahun')->orderBy('urutan')->take(4)->get(),
    ]);
})->name('home');

Route::get('/profil/{slug}', function (string $slug) {
    $halaman = Halaman::published()->where('slug', $slug)->firstOrFail();

    return view('public.profil-show', ['halaman' => $halaman]);
})->name('profil.show');

Route::get('/ppdb', fn () => view('public.ppdb'))->name('ppdb');

Route::get('/guru', function () {
    return view('public.guru', ['guru' => Guru::orderBy('urutan')->get()]);
})->name('guru.index');

Route::get('/fasilitas', function () {
    return view('public.fasilitas', ['fasilitas' => Fasilitas::orderBy('urutan')->get()]);
})->name('fasilitas.index');

Route::get('/berita', function () {
    return view('public.berita-index', ['berita' => Berita::published()->latest('tanggal')->paginate(9)]);
})->name('berita.index');

Route::get('/berita/{slug}', function (string $slug) {
    $berita = Berita::published()->where('slug', $slug)->firstOrFail();

    return view('public.berita-show', ['berita' => $berita]);
})->name('berita.show');

Route::get('/ekstrakurikuler', function () {
    pastikanModulAktif('ekstrakurikuler');

    return view('public.ekstrakurikuler', ['ekskul' => Ekstrakurikuler::orderBy('urutan')->get()]);
})->name('ekskul.index');

Route::get('/prestasi', function () {
    pastikanModulAktif('prestasi');

    return view('public.prestasi', ['prestasi' => Prestasi::orderByDesc('tahun')->orderBy('urutan')->get()]);
})->name('prestasi.index');

Route::get('/galeri', function () {
    pastikanModulAktif('galeri');

    return view('public.galeri', ['galeri' => Galeri::orderBy('urutan')->latest()->get()]);
})->name('galeri.index');

Route::get('/agenda', function () {
    pastikanModulAktif('agenda');

    return view('public.agenda', ['agenda' => Agenda::orderBy('mulai')->get()]);
})->name('agenda.index');

Route::get('/kontak', fn () => view('public.kontak'))->name('kontak');

Route::post('/kontak', function (Request $request) {
    if ($request->filled('website')) {
        return back(); // honeypot terisi = bot
    }

    $data = $request->validate([
        'nama' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:160'],
        'pesan' => ['required', 'string', 'max:2000'],
    ]);

    PesanKontak::create([...$data, 'ip' => $request->ip()]);

    return back()->with('kontak_sukses', 'Pesan terkirim. Terima kasih, kami akan membalas secepatnya.');
})->middleware('throttle:5,1')->name('kontak.kirim');

Route::get('/sitemap.xml', function () {
    $modul = app(SchoolSettings::class)->modul_aktif ?? [];
    $urls = [route('home'), route('ppdb'), route('guru.index'), route('fasilitas.index'), route('kontak')];

    foreach (Halaman::published()->get() as $h) {
        $urls[] = route('profil.show', $h->slug);
    }
    if ($modul['berita'] ?? false) {
        $urls[] = route('berita.index');
        foreach (Berita::published()->get() as $b) {
            $urls[] = route('berita.show', $b->slug);
        }
    }
    foreach (['ekstrakurikuler' => 'ekskul.index', 'prestasi' => 'prestasi.index', 'galeri' => 'galeri.index', 'agenda' => 'agenda.index'] as $key => $routeName) {
        if ($modul[$key] ?? false) {
            $urls[] = route($routeName);
        }
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach (array_unique($urls) as $u) {
        $xml .= '<url><loc>'.e($u).'</loc></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');
