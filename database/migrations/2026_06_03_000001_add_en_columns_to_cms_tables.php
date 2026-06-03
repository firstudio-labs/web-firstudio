<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berandas', function (Blueprint $table) {
            $table->string('judul_utama_en')->nullable()->after('judul_utama');
            $table->text('slogan_en')->nullable()->after('slogan');
            $table->text('keterangan_en')->nullable()->after('keterangan');
            $table->string('judul_sekunder_en')->nullable()->after('judul_sekunder');
        });

        Schema::table('tentangs', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
            $table->text('keterangan_memilih_en')->nullable()->after('keterangan_memilih');
            $table->text('keterangan_nilai_en')->nullable()->after('keterangan_nilai');
            $table->json('keterangan_hitungan_en')->nullable()->after('keterangan_hitungan');
        });
    }

    public function down(): void
    {
        Schema::table('berandas', function (Blueprint $table) {
            $table->dropColumn([
                'judul_utama_en',
                'slogan_en',
                'keterangan_en',
                'judul_sekunder_en',
            ]);
        });

        Schema::table('tentangs', function (Blueprint $table) {
            $table->dropColumn([
                'judul_en',
                'deskripsi_en',
                'keterangan_memilih_en',
                'keterangan_nilai_en',
                'keterangan_hitungan_en',
            ]);
        });
    }
};
