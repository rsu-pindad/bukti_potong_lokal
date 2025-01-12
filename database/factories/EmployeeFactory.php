<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        return [
            'npp' => fake()->randomNumber(5, true),
            'npp_baru' => null,
            'nama' => fake()->name(),
            'status_kepegawaian' => fake()->randomElement(['DIREKTUR', 'TETAP', 'KARYAWAN', 'PARUH_WAKTU', 'MITRA', 'OS']),
            'nik' => fake()->nik(),
            'npwp' => fake()->nik(),
            'status_ptkp' => fake()->randomELement(['K0', 'TK0', 'K1', 'K2', 'K3']),
            'email' => fake()->safeEmail(),
            'no_hp' => fake()->phoneNumber(),
            'epin' => null,
            'tmt_masuk' => Carbon::now(),
            'tmt_keluar' => null,
        ];
    }
}
