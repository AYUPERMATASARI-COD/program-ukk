<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('area_parkirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_area', 100);
            $table->unsignedInteger('kapasitas');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor', 20)->unique();
            $table->enum('jenis_kendaraan', ['motor', 'mobil']);
            $table->string('nama_pemilik', 100)->nullable();
            $table->foreignId('area_id')->nullable()->constrained('area_parkirs')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kendaraan', ['motor', 'mobil']);
            $table->decimal('tarif_awal', 12, 2);
            $table->decimal('tarif_perjam', 12, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->nullable()->constrained('kendaraans')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('waktu_masuk')->nullable();
            $table->timestamp('waktu_keluar')->nullable();
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->string('status', 20)->default('masuk');
            $table->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('aktivitas', 100);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('tarifs');
        Schema::dropIfExists('kendaraans');
        Schema::dropIfExists('area_parkirs');
    }
};
