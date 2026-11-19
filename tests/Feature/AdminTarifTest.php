<?php

namespace Tests\Feature;

use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTarifTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_tarif_with_bus_and_truck_types(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.tarif.create'))
            ->assertOk()
            ->assertSee('Bis')
            ->assertSee('Truk');

        $response = $this->actingAs($admin)
            ->post(route('admin.tarif.store'), [
                'jenis_kendaraan' => 'truk',
                'tarif_awal' => 12000,
                'tarif_perjam' => 6000,
                'keterangan' => 'Tarif standar truk',
            ]);

        $response->assertRedirect(route('admin.tarif.index'));
        $this->assertDatabaseHas('tarifs', [
            'jenis_kendaraan' => 'truk',
            'tarif_awal' => '12000.00',
            'tarif_perjam' => '6000.00',
        ]);
        $this->assertDatabaseHas('log_aktivitas', [
            'user_id' => $admin->id,
            'aktivitas' => 'Tambah tarif',
            'keterangan' => 'Tarif truk ditambahkan.',
        ]);
        $this->assertTrue(Tarif::where('jenis_kendaraan', 'truk')->exists());
    }

    public function test_login_accepts_legacy_plaintext_passwords_and_rehashes_them(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'username' => 'admin',
                'password' => 'admin123',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertNotSame('admin123', User::where('username', 'admin')->first()->password);
    }
}
