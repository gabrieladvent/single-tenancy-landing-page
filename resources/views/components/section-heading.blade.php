@props(['label' => null, 'judul'])
{{-- Pola wajib: label kecil + judul serif + garis aksen (docs/desain.md §8) --}}
<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    @if($label)
        <span class="section-label">{{ $label }}</span>
    @endif
    <h2 class="text-2xl mt-2">{{ $judul }}</h2>
    <span class="accent-rule mt-4"></span>
</div>
