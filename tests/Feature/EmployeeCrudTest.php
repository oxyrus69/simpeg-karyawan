<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

// Menyiapkan data dasar untuk setiap tes
beforeEach(function () {
    // Membuat pengguna Admin
    $this->admin = User::factory()->create(['role' => 'admin']);
    
    // Membuat data awal Departemen dan Jabatan
    $this->department = Department::factory()->create();
    $this->position = Position::factory()->create();
    
    // Membuat satu pengguna biasa yang akan kita daftarkan sebagai karyawan
    $this->user = User::factory()->create(['role' => 'karyawan']);
});

describe('Employee CRUD', function() {

    test('admin can view employees page', function () {
        actingAs($this->admin)
            ->get(route('employees.index'))
            ->assertOk()
            ->assertSee('Manajemen Karyawan');
    });

    test('admin can create a new employee', function () {
        // Data karyawan baru yang akan kita kirim
        $newEmployeeData = [
            'user_id' => $this->user->id,
            'department_id' => $this->department->id,
            'position_id' => $this->position->id,
            'nama_lengkap' => 'Budi Sudarsono',
            'alamat' => 'Jl. Merdeka No. 17',
            'no_telepon' => '081234567890',
            'tanggal_bergabung' => '2023-01-10',
        ];

        actingAs($this->admin)
            ->post(route('employees.store'), $newEmployeeData)
            ->assertRedirect(route('employees.index'))
            ->assertSessionHas('success');

        // Memastikan data karyawan baru ada di database
        $this->assertDatabaseHas('employees', [
            'nama_lengkap' => 'Budi Sudarsono',
            'user_id' => $this->user->id,
        ]);
    });
    
    test('employee creation requires all necessary fields', function () {
        actingAs($this->admin)
            ->post(route('employees.store'), []) // Mengirim data kosong
            ->assertSessionHasErrors([
                'user_id', 'department_id', 'position_id', 'nama_lengkap', 
                'alamat', 'no_telepon', 'tanggal_bergabung'
            ]); // Mengharapkan error validasi untuk semua field ini
    });

    test('admin can update employee data', function () {
        // Buat satu karyawan sebagai data awal
        $employee = Employee::factory()->create();
        $newFullName = 'Ahmad Junaidi';

        actingAs($this->admin)
            ->put(route('employees.update', $employee), [
                // Mengirim semua data yang diperlukan, termasuk yang baru
                'user_id' => $employee->user_id,
                'department_id' => $employee->department_id,
                'position_id' => $employee->position_id,
                'nama_lengkap' => $newFullName,
                'alamat' => $employee->alamat,
                'no_telepon' => $employee->no_telepon,
                'tanggal_bergabung' => $employee->tanggal_bergabung->format('Y-m-d'),
            ])
            ->assertRedirect(route('employees.index'))
            ->assertSessionHas('success');

        // Memastikan nama baru ada di database
        $this->assertDatabaseHas('employees', ['nama_lengkap' => $newFullName]);
    });
    
    test('admin can delete an employee', function () {
        $employee = Employee::factory()->create();

        actingAs($this->admin)
            ->delete(route('employees.destroy', $employee))
            ->assertRedirect(route('employees.index'))
            ->assertSessionHas('success');
        
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    });

});
