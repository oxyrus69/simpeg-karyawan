<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Setiap kali factory ini dipanggil, ia akan menghasilkan sebuah
        // nama departemen palsu (contoh: "Marketing", "Sales", dll).
        return [
            'nama_departemen' => $this->faker->unique()->word() . ' Department',
        ];
    }
}