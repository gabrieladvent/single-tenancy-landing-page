<?php

namespace App\Support;

use App\Settings\SchoolSettings;

/**
 * Membangun lapisan tema runtime dari Settings (lihat docs/desain.md §2-3, docs/arsitektur.md §7).
 * Lapisan brand (preset/override) + style pack (font/radius) → CSS variables yang di-inline di <head>.
 */
class Theme
{
    /** Preset warna terverifikasi kontras (desain.md §3). */
    public const PRESETS = [
        'biru-akademik' => [
            'brand' => ['50' => '#f3f7fd', '100' => '#e8eef8', '200' => '#b9cbe8', '400' => '#5a7fc4', '500' => '#2e5aac', '700' => '#1b3a6b', '900' => '#122b52'],
            'accent' => ['100' => '#fbf1d8', '500' => '#e4b23c', '600' => '#c8961f'],
        ],
        'hijau-tumbuh' => [
            'brand' => ['50' => '#f0f8f4', '100' => '#dcefe6', '200' => '#aed8c4', '400' => '#5cb08c', '500' => '#2f8f6b', '700' => '#1f6049', '900' => '#143f30'],
            'accent' => ['100' => '#fbf1d8', '500' => '#e4b23c', '600' => '#c8961f'],
        ],
        'marun-klasik' => [
            'brand' => ['50' => '#fbf3f4', '100' => '#f6e3e5', '200' => '#e6b9bd', '400' => '#bd5b64', '500' => '#8c2f39', '700' => '#641f27', '900' => '#43141a'],
            'accent' => ['100' => '#f8eed8', '500' => '#d6a24e', '600' => '#b9842f'],
        ],
        'tosca-modern' => [
            'brand' => ['50' => '#eef9f9', '100' => '#d8efef', '200' => '#a7dcdc', '400' => '#48b3b3', '500' => '#1f8a8a', '700' => '#155e5e', '900' => '#0e3f3f'],
            'accent' => ['100' => '#fdeede', '500' => '#f2a65a', '600' => '#d9853a'],
        ],
    ];

    /** Style pack: tipografi + radius (desain.md §2). */
    public const PACKS = [
        'klasik' => ['heading' => 'Fraunces', 'body' => 'Plus Jakarta Sans', 'radius' => '0.75rem'],
        'modern' => ['heading' => 'Plus Jakarta Sans', 'body' => 'Inter', 'radius' => '0.375rem'],
        'hangat' => ['heading' => 'Lora', 'body' => 'Nunito Sans', 'radius' => '1.25rem'],
    ];

    public function __construct(protected SchoolSettings $settings) {}

    /** @return array{0:int,1:int,2:int} */
    public static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    }

    /** Campur warna dengan target (0=hitam, 255=putih) sebesar $ratio (0..1). */
    protected static function mix(string $hex, int $target, float $ratio): string
    {
        [$r, $g, $b] = self::hexToRgb($hex);

        return sprintf(
            '#%02x%02x%02x',
            (int) round($r * (1 - $ratio) + $target * $ratio),
            (int) round($g * (1 - $ratio) + $target * $ratio),
            (int) round($b * (1 - $ratio) + $target * $ratio),
        );
    }

    /** Bangun ramp 50..900 dari satu hex (terang→gelap). */
    public static function generateRamp(string $hex): array
    {
        return [
            '50' => self::mix($hex, 255, 0.92),
            '100' => self::mix($hex, 255, 0.84),
            '200' => self::mix($hex, 255, 0.60),
            '400' => self::mix($hex, 255, 0.25),
            '500' => $hex,
            '700' => self::mix($hex, 0, 0.25),
            '900' => self::mix($hex, 0, 0.45),
        ];
    }

    /** Rasio kontras warna terhadap putih (WCAG). */
    public static function contrastWithWhite(string $hex): float
    {
        $lum = self::relativeLuminance($hex);

        return (1.0 + 0.05) / ($lum + 0.05);
    }

    protected static function relativeLuminance(string $hex): float
    {
        $channels = array_map(function ($c) {
            $c /= 255;

            return $c <= 0.03928 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
        }, self::hexToRgb($hex));

        return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
    }

    protected function preset(): array
    {
        return self::PRESETS[$this->settings->preset_tema] ?? self::PRESETS['biru-akademik'];
    }

    protected function pack(): array
    {
        return self::PACKS[$this->settings->style_pack] ?? self::PACKS['klasik'];
    }

    /** CSS variables untuk di-inline di <head>. */
    public function cssVariables(): string
    {
        $preset = $this->preset();
        $pack = $this->pack();

        $brand = $preset['brand'];
        // Override: bila admin mengisi warna utama (dari logo), generate ramp penuh dari satu hex.
        if (! empty($this->settings->warna_utama)) {
            $brand = self::generateRamp($this->settings->warna_utama);
        }
        $accent = $preset['accent'];
        if (! empty($this->settings->warna_aksen)) {
            $accent['500'] = $this->settings->warna_aksen;
        }

        $lines = [];
        foreach ($brand as $k => $v) {
            $lines[] = "--brand-{$k}:{$v}";
        }
        foreach ($accent as $k => $v) {
            $lines[] = "--accent-{$k}:{$v}";
        }
        $lines[] = "--font-heading:'{$pack['heading']}',ui-serif,Georgia,serif";
        $lines[] = "--font-body:'{$pack['body']}',ui-sans-serif,system-ui,sans-serif";
        $lines[] = "--radius-pack:{$pack['radius']}";

        // html:root (specificity lebih tinggi dari :root) → override default app.css
        // apa pun urutan muatnya (build maupun dev/HMR).
        return 'html:root{' . implode(';', $lines) . '}';
    }

    /** URL Google Fonts untuk pack aktif. */
    public function googleFontsUrl(): string
    {
        $pack = $this->pack();
        $families = [
            $pack['heading'] => 'wght@400;500;600;700',
            $pack['body'] => 'wght@400;500;600;700',
        ];
        $parts = [];
        foreach ($families as $name => $weights) {
            $parts[] = 'family=' . str_replace(' ', '+', $name) . ':' . $weights;
        }

        return 'https://fonts.googleapis.com/css2?' . implode('&', $parts) . '&display=swap';
    }
}
