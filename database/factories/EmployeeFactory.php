<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Saat factory ini dipanggil, ia akan:
        // 1. Membuat User baru
        // 2. Membuat Departemen baru
        // 3. Membuat Jabatan baru
        // 4. Mengaitkan semuanya ke Karyawan baru ini
        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'position_id' => Position::factory(),
            'nama_lengkap' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->phoneNumber(),
            'tanggal_bergabung' => $this->faker->date(),
        ];
    }
}