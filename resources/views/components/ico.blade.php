@props(['name', 'class' => 'w-5 h-5'])
@php
$paths = [
    'phone' => '<path d="M3 5a2 2 0 0 1 2-2h2.5a1 1 0 0 1 .95.68l1.2 3.6a1 1 0 0 1-.5 1.2L7.8 9.8a13 13 0 0 0 6.4 6.4l1.32-1.55a1 1 0 0 1 1.2-.5l3.6 1.2a1 1 0 0 1 .68.95V19a2 2 0 0 1-2 2A16 16 0 0 1 3 5z"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
    'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    'map-pin' => '<path d="M12 21s7-6.4 7-11a7 7 0 1 0-14 0c0 4.6 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
    'cap' => '<path d="m22 10-10-5L2 10l10 5 10-5z"/><path d="M6 12v5c0 1 2.7 3 6 3s6-2 6-3v-5"/>',
    'heart' => '<path d="M12 20s-7-4.6-9.2-9A4.8 4.8 0 0 1 12 6a4.8 4.8 0 0 1 9.2 5c-2.2 4.4-9.2 9-9.2 9z"/>',
    'sparkles' => '<path d="M12 3l1.8 4.7L18.5 9l-4.7 1.8L12 15.5 10.2 10.8 5.5 9l4.7-1.3L12 3z"/><path d="M19 14l.8 2 2 .8-2 .8-.8 2-.8-2-2-.8 2-.8.8-2z"/>',
    'trophy' => '<path d="M8 4h8v4a4 4 0 0 1-8 0V4z"/><path d="M8 5H5v2a3 3 0 0 0 3 3M16 5h3v2a3 3 0 0 1-3 3M10 12v3M14 12v3M8 19h8M9 19l.5-2h5l.5 2"/>',
    'newspaper' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h7M7 12h7M7 16h4M17 8h0v8"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/>',
    'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
    'youtube' => '<rect x="3" y="6" width="18" height="12" rx="3"/><path d="m10 9 5 3-5 3V9z"/>',
    'facebook' => '<path d="M14 8h2V5h-2a3 3 0 0 0-3 3v2H9v3h2v6h3v-6h2l1-3h-3V8a1 1 0 0 1 1-1z"/>',
    'users' => '<circle cx="9" cy="8" r="3"/><path d="M3 20a6 6 0 0 1 12 0M16 6a3 3 0 0 1 0 6M21 20a6 6 0 0 0-4-5.6"/>',
    'building' => '<rect x="5" y="3" width="14" height="18" rx="1"/><path d="M9 7h2M13 7h2M9 11h2M13 11h2M9 15h2M13 15h2"/>',
    'quote' => '<path d="M7 7h4v4c0 3-2 5-4 5V7zM15 7h4v4c0 3-2 5-4 5V7z"/>',
];
@endphp
<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $paths[$name] ?? '' !!}
</svg>
