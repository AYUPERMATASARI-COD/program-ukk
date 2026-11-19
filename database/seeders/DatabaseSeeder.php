<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Petugas Parkir',
                'email' => 'petugas@example.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );

        User::updateOrCreate(
            ['username' => 'owner'],
            [
                'name' => 'Owner Parkir',
                'email' => 'owner@example.com',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );

        AreaParkir::firstOrCreate(
            ['nama_area' => 'Area Motor'],
            ['kapasitas' => 100, 'keterangan' => 'Area parkir khusus sepeda motor']
        );

        AreaParkir::firstOrCreate(
            ['nama_area' => 'Area Mobil'],
            ['kapasitas' => 50, 'keterangan' => 'Area parkir khusus mobil']
        );

        AreaParkir::firstOrCreate(
            ['nama_area' => 'Area VIP'],
            ['kapasitas' => 20, 'keterangan' => 'Area parkir prioritas']
        );

        Tarif::firstOrCreate(
            ['jenis_kendaraan' => 'motor'],
            ['tarif_awal' => 2000, 'tarif_perjam' => 1000, 'keterangan' => 'Tarif standar motor']
        );

        Tarif::firstOrCreate(
            ['jenis_kendaraan' => 'mobil'],
            ['tarif_awal' => 5000, 'tarif_perjam' => 2000, 'keterangan' => 'Tarif standar mobil']
        );

        Tarif::firstOrCreate(
            ['jenis_kendaraan' => 'bis'],
            ['tarif_awal' => 10000, 'tarif_perjam' => 5000, 'keterangan' => 'Tarif standar bis']
        );

        Tarif::firstOrCreate(
            ['jenis_kendaraan' => 'truk'],
            ['tarif_awal' => 12000, 'tarif_perjam' => 6000, 'keterangan' => 'Tarif standar truk']
        );
    }
}
