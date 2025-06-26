<?php

// Menggunakan namespace dan class yang diperlukan untuk testing
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// Mendefinisikan grup tes untuk kerapian, ini opsional
describe('Admin Access Control', function() {

    // Tes pertama: Memastikan pengguna yang tidak login (tamu) dialihkan
    test('guests cannot see admin pages', function () {
        // Pura-pura mengakses halaman 'users.index' sebagai tamu
        // 'get()' adalah simulasi membuka URL di browser
        $response = get(route('users.index'));

        // 'expect()' adalah inti dari PEST, kita 'mengharapkan' sesuatu terjadi
        // '->assertRedirect('/login')' memeriksa apakah pengguna dialihkan ke halaman login
        $response->assertRedirect('/login');
    });

    // Tes kedua: Memastikan pengguna dengan peran 'karyawan' ditolak
    test('non-admin users are forbidden from admin pages', function () {
        // Buat pengguna baru di database dengan peran 'karyawan'
        // 'User::factory()->create()' adalah cara cepat membuat data dummy
        $user = User::factory()->create([
            'role' => 'karyawan',
        ]);

        // 'actingAs($user)' mensimulasikan login sebagai pengguna yang baru kita buat
        // Kemudian, kita mencoba mengakses halaman 'users.index'
        $response = actingAs($user)->get(route('users.index'));

        // '->assertForbidden()' memeriksa apakah server merespons dengan error 403 (Forbidden)
        // Ini membuktikan middleware 'admin' kita bekerja
        $response->assertForbidden();
    });

    // Tes ketiga: Memastikan pengguna 'admin' BISA mengakses halaman
    test('admin users can see admin pages', function () {
        // Buat pengguna baru dengan peran 'admin'
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Login sebagai admin dan akses halaman 'users.index'
        $response = actingAs($admin)->get(route('users.index'));

        // '->assertOk()' memeriksa apakah server merespons dengan status 200 (OK/Sukses)
        // Ini membuktikan pengguna admin bisa melihat halaman tersebut
        $response->assertOk();
    });

});
