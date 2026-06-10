<?php

use App\Settings\SchoolSettings;

if (!function_exists('pastikanModulAktif')) {
    function pastikanModulAktif(string $key): void
    {
        if (! (app(SchoolSettings::class)->modul_aktif[$key] ?? false)) {
            abort(404);
        }
    }
}
