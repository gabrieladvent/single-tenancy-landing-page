@inject('school', \App\Settings\SchoolSettings::class)
<div class="hidden md:block bg-brand-900 text-white/75 text-xs">
    <div class="container-page flex items-center justify-between h-9">
        <div class="flex items-center gap-5">
            @if($school->alamat)
                <span class="inline-flex items-center gap-1.5"><x-ico name="map-pin" class="w-3.5 h-3.5" /> {{ \Illuminate\Support\Str::limit($school->alamat, 60) }}</span>
            @endif
            @if($school->telepon)
                <span class="inline-flex items-center gap-1.5"><x-ico name="phone" class="w-3.5 h-3.5" /> {{ $school->telepon }}</span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5"><x-ico name="clock" class="w-3.5 h-3.5" /> {{ $school->jam_layanan }}</span>
            <span class="flex items-center gap-2 pl-3 border-l border-white/15">
                @if($school->instagram)<a href="{{ $school->instagram }}" aria-label="Instagram" class="hover:text-white"><x-ico name="instagram" class="w-3.5 h-3.5" /></a>@endif
                @if($school->youtube)<a href="{{ $school->youtube }}" aria-label="YouTube" class="hover:text-white"><x-ico name="youtube" class="w-3.5 h-3.5" /></a>@endif
                @if($school->facebook)<a href="{{ $school->facebook }}" aria-label="Facebook" class="hover:text-white"><x-ico name="facebook" class="w-3.5 h-3.5" /></a>@endif
            </span>
        </div>
    </div>
</div>
