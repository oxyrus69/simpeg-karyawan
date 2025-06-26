<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; // Penting: Membersihkan DB setiap tes
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

// Menggunakan RefreshDatabase agar setiap tes berjalan di database yang bersih
uses(RefreshDatabase::class);

// Mendefinisikan pengguna Admin yang akan kita gunakan di setiap tes
beforeEach(function () {
    // Membuat satu pengguna admin dan menyimpannya dalam variabel 'admin'
    $this->admin = User::factory()->create(['role' => 'admin']);
});

// Grup tes untuk CRUD Departemen
describe('Department CRUD', function() {

    // Tes untuk memastikan admin bisa melihat halaman daftar departemen
    test('admin can view departments page', function () {
        actingAs($this->admin)
            ->get(route('departments.index'))
            ->assertOk() // Memastikan halaman terbuka (status 200)
            ->assertSee('Manajemen Departemen'); // Memastikan teks judul ada di halaman
    });

    // Tes untuk memastikan admin bisa membuat departemen baru
    test('admin can create a new department', function () {
        $departmentName = 'Teknologi Informasi';

        actingAs($this->admin)
            ->post(route('departments.store'), [
                'nama_departemen' => $departmentName,
            ])
            ->assertRedirect(route('departments.index')) // Memastikan diarahkan kembali setelah sukses
            ->assertSessionHas('success'); // Memastikan ada notifikasi sukses

        // Memeriksa apakah data benar-benar tersimpan di database
        $this->assertDatabaseHas('departments', [
            'nama_departemen' => $departmentName
        ]);
    });

    // Tes untuk memastikan validasi berjalan (tidak bisa membuat departemen tanpa nama)
    test('department creation requires a name', function () {
        actingAs($this->admin)
            ->post(route('departments.store'), [
                'nama_departemen' => '', // Mengirim data kosong
            ])
            ->assertSessionHasErrors('nama_departemen'); // Mengharapkan error validasi untuk field ini
    });

    // Tes untuk memastikan admin bisa memperbarui data departemen
    test('admin can update a department', function () {
        // Pertama, buat departemen yang akan di-update
        $department = Department::factory()->create(['nama_departemen' => 'HRD Lama']);
        $newDepartmentName = 'Sumber Daya Manusia';

        actingAs($this->admin)
            ->put(route('departments.update', $department), [
                'nama_departemen' => $newDepartmentName,
            ])
            ->assertRedirect(route('departments.index'))
            ->assertSessionHas('success');

        // Pastikan nama baru ada di DB dan nama lama sudah tidak ada
        $this->assertDatabaseHas('departments', ['nama_departemen' => $newDepartmentName]);
        $this->assertDatabaseMissing('departments', ['nama_departemen' => 'HRD Lama']);
    });

    // Tes untuk memastikan admin bisa menghapus departemen
    test('admin can delete a department', function () {
        $department = Department::factory()->create();

        actingAs($this->admin)
            ->delete(route('departments.destroy', $department))
            ->assertRedirect(route('departments.index'))
            ->assertSessionHas('success');
        
        // Pastikan data departemen sudah hilang dari database
        $this->assertDatabaseMissing('departments', [
            'id' => $department->id
        ]);
    });
});
