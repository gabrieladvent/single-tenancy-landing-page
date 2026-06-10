@inject('school', \App\Settings\SchoolSettings::class)
<div
    x-data="{ show: ! localStorage.getItem('cookie-consent') }"
    x-show="show"
    x-cloak
    class="fixed inset-x-0 bottom-0 z-[500] bg-surface border-t border-line"
>
    <div class="container-page py-4 flex flex-col sm:flex-row items-center gap-4 justify-between">
        <p class="text-sm text-ink-soft">Situs ini memakai cookie untuk analitik. Dengan melanjutkan, Anda menyetujui penggunaannya.</p>
        <div class="flex gap-3 shrink-0">
            <button
                @click="localStorage.setItem('cookie-consent','yes'); show=false; window.loadAnalytics && window.loadAnalytics()"
                class="px-5 py-2 rounded-[var(--radius-pack)] bg-brand-500 text-white text-sm font-medium hover:bg-brand-700"
            >Setuju</button>
            <button
                @click="localStorage.setItem('cookie-consent','no'); show=false"
                class="px-5 py-2 rounded-[var(--radius-pack)] text-ink-soft text-sm"
            >Tolak</button>
        </div>
    </div>
</div>

@if($school->analytics_ga_id)
<script>
window.loadAnalytics = function () {
    if (window.__gaLoaded) return; window.__gaLoaded = true;
    var s = document.createElement('script'); s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $school->analytics_ga_id }}';
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date()); gtag('config', '{{ $school->analytics_ga_id }}');
};
if (localStorage.getItem('cookie-consent') === 'yes') window.loadAnalytics();
</script>
@endif
