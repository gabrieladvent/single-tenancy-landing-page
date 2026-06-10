<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->date('tanggal');
            $table->string('kategori')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('isi')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('penulis_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['is_published', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
