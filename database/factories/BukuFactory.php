<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'=>$this->faker->unique()->randomNumber(),
            'judul'=>$this->faker->title(),
            'penulis'=>$this->faker->name(),
            'harga'=>$this->faker->randomNumber(),
            'tgl_terbit'=>$this->faker->date('Y-m-d')
            //
        ];
    }
}
