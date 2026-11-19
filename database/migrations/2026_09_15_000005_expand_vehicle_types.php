<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE kendaraans MODIFY jenis_kendaraan ENUM('motor', 'mobil', 'bis', 'truk') NOT NULL");
        DB::statement("ALTER TABLE tarifs MODIFY jenis_kendaraan ENUM('motor', 'mobil', 'bis', 'truk') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE kendaraans MODIFY jenis_kendaraan ENUM('motor', 'mobil') NOT NULL");
        DB::statement("ALTER TABLE tarifs MODIFY jenis_kendaraan ENUM('motor', 'mobil') NOT NULL");
    }
};