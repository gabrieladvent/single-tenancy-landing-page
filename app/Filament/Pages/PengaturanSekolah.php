<?php

namespace App\Filament\Pages;

use App\Settings\SchoolSettings;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PengaturanSekolah extends SettingsPage
{
    protected static string $settings = SchoolSettings::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Sekolah';

    protected static ?string $title = 'Pengaturan Sekolah';

    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([
                Tab::make('Identitas')->icon(Heroicon::OutlinedIdentification)->schema([
                    Grid::make(2)->schema([
                        TextInput::make('nama_lengkap')->label('Nama Lengkap')->required(),
                        TextInput::make('nama_singkat')->label('Nama Singkat')->required(),
                        Select::make('jenjang')->options(['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'SMK' => 'SMK'])->required(),
                        Select::make('status')->options(['Negeri' => 'Negeri', 'Swasta' => 'Swasta'])->required(),
                        TextInput::make('npsn')->label('NPSN'),
                        TextInput::make('akreditasi'),
                        Select::make('agama')->options([
                            'islam' => 'Islam', 'katolik' => 'Katolik', 'kristen' => 'Kristen',
                            'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu',
                        ])->helperText('Mengatur istilah kerohanian di situs.')->required(),
                    ]),
                    TextInput::make('moto')->label('Moto / Tagline')->columnSpanFull(),
                ]),

                Tab::make('Tema')->icon(Heroicon::OutlinedSwatch)->schema([
                    Grid::make(2)->schema([
                        Select::make('style_pack')->label('Style Pack')->options([
                            'klasik' => 'Klasik (serif, formal)',
                            'modern' => 'Modern (sans, tegas)',
                            'hangat' => 'Hangat (rounded, ramah)',
                        ])->required(),
                        Select::make('preset_tema')->label('Preset Warna')->options([
                            'biru-akademik' => 'Biru Akademik',
                            'hijau-tumbuh' => 'Hijau Tumbuh',
                            'marun-klasik' => 'Marun Klasik',
                            'tosca-modern' => 'Tosca Modern',
                        ])->required(),
                        ColorPicker::make('warna_utama')->label('Warna Utama (override dari logo)')
                            ->helperText('Kosongkan untuk pakai preset. Teks putih harus kontras (≥ 4.5:1).')
                            ->rule(function () {
                                return function (string $attribute, $value, \Closure $fail) {
                                    if ($value && \App\Support\Theme::contrastWithWhite($value) < 4.5) {
                                        $fail('Warna terlalu terang — teks putih tidak terbaca. Pilih warna lebih gelap.');
                                    }
                                };
                            }),
                        ColorPicker::make('warna_aksen')->label('Warna Aksen (opsional)'),
                    ]),
                    FileUpload::make('logo')->label('Logo Sekolah')
                        ->image()->disk('public')->directory('logo')->visibility('public')
                        ->helperText('SVG/PNG transparan. Min tinggi 40px.')->columnSpanFull(),
                    FileUpload::make('hero_image')->label('Foto Latar Hero (opsional)')
                        ->image()->imageEditor()->disk('public')->directory('hero')->visibility('public')
                        ->helperText('Foto besar untuk latar hero beranda. Kosong = pakai gradien.')->columnSpanFull(),
                ]),

                Tab::make('Kontak')->icon(Heroicon::OutlinedMapPin)->schema([
                    Textarea::make('alamat')->rows(2)->columnSpanFull(),
                    Grid::make(2)->schema([
                        TextInput::make('telepon'),
                        TextInput::make('whatsapp')->label('WhatsApp'),
                        TextInput::make('email')->email(),
                        TextInput::make('jam_layanan')->label('Jam Layanan'),
                    ]),
                    Textarea::make('peta_embed')->label('Embed Peta (iframe Google Maps)')->rows(3)->columnSpanFull(),
                ]),

                Tab::make('Sosial')->icon(Heroicon::OutlinedShare)->schema([
                    Grid::make(2)->schema([
                        TextInput::make('instagram')->url()->prefixIcon(Heroicon::OutlinedCamera),
                        TextInput::make('youtube')->url(),
                        TextInput::make('facebook')->url(),
                        TextInput::make('tiktok')->label('TikTok')->url(),
                    ]),
                ]),

                Tab::make('Modul')->icon(Heroicon::OutlinedSquares2x2)->schema([
                    Grid::make(3)->schema([
                        Toggle::make('modul_aktif.ppdb')->label('PPDB'),
                        Toggle::make('modul_aktif.berita')->label('Berita'),
                        Toggle::make('modul_aktif.keagamaan')->label('Kerohanian'),
                        Toggle::make('modul_aktif.galeri')->label('Galeri'),
                        Toggle::make('modul_aktif.ekstrakurikuler')->label('Ekstrakurikuler'),
                        Toggle::make('modul_aktif.prestasi')->label('Prestasi'),
                        Toggle::make('modul_aktif.agenda')->label('Agenda'),
                        Toggle::make('modul_aktif.download')->label('Download'),
                        Toggle::make('modul_aktif.alumni')->label('Alumni'),
                    ]),
                ]),

                Tab::make('PPDB & Lain-lain')->icon(Heroicon::OutlinedCog6Tooth)->schema([
                    Grid::make(2)->schema([
                        Select::make('ppdb_mode')->label('Mode PPDB')->options([
                            'info' => 'Info (tombol ke link eksternal)',
                            'online' => 'Online (v2 — belum aktif)',
                        ])->required(),
                        TextInput::make('ppdb_link')->label('Link Daftar PPDB')->url()
                            ->helperText('Tujuan tombol "Daftar" (WhatsApp/Google Form).'),
                        Select::make('timezone')->label('Zona Waktu')->options([
                            'Asia/Jakarta' => 'WIB (Jakarta)',
                            'Asia/Makassar' => 'WITA (Makassar)',
                            'Asia/Jayapura' => 'WIT (Jayapura)',
                        ])->required(),
                        TextInput::make('analytics_ga_id')->label('Google Analytics ID')
                            ->placeholder('G-XXXXXXXXXX'),
                    ]),
                ]),
            ]),
        ]);
    }
}
