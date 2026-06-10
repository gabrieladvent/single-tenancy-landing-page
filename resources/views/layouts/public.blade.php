@inject('school', \App\Settings\SchoolSettings::class)
@php($theme = new \App\Support\Theme($school))
<!DOCTYPE html>
<html lang="{{ $school->locale ?? 'id' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') — {{ $school->nama_lengkap }}@else{{ $school->nama_lengkap }}@endif</title>
    <meta name="description" content="@yield('description', $school->moto)">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / share (WA, FB) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $school->nama_lengkap }}">
    <meta property="og:title" content="@hasSection('title')@yield('title')@else{{ $school->nama_lengkap }}@endif">
    <meta property="og:description" content="@yield('description', $school->moto)">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($school->logo)<meta property="og:image" content="{{ asset('storage/'.$school->logo) }}">@endif
    <meta name="twitter:card" content="summary_large_image">

    {{-- Schema.org School --}}
    <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'School',
        'name' => $school->nama_lengkap,
        'url' => url('/'),
        'logo' => $school->logo ? asset('storage/'.$school->logo) : null,
        'address' => $school->alamat ?: null,
        'telephone' => $school->telepon ?: null,
        'email' => $school->email ?: null,
        'slogan' => $school->moto ?: null,
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ $theme->googleFontsUrl() }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tema runtime dari Settings (docs/arsitektur.md §7) --}}
    {{-- WAJIB setelah @vite agar override menang atas :root default di app.css --}}
    <style>{!! $theme->cssVariables() !!}</style>
</head>
<body class="min-h-screen flex flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[300] focus:bg-surface focus:px-4 focus:py-2 focus:rounded">Lewati ke konten</a>

    @include('partials.topbar')
    @include('partials.header')

    <main id="konten" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @if($school->analytics_ga_id)
        @include('partials.cookie-consent')
    @endif
</body>
</html>
