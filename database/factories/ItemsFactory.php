<?php

namespace Database\Factories;

use App\Models\Items;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemsFactory extends Factory
{
    protected $model = Items::class;

    public function definition()
    {
        return [
            'foto' => '/assets/img/product-3.jpg',
            'nama' => $this->faker->word,
            'desk' => $this->faker->sentence,
            'kategori' => $this->faker->numberBetween(0, 3),
            'stok' => $this->faker->numberBetween(1, 50),
            'harga_awal' => $this->faker->numberBetween(500, 5000),
            'harga_jual' => $this->faker->numberBetween(600, 6000),
            'email' => 'tes@gmail.com',
            'kode' => $this->faker->unique()->numberBetween(1000, 9999),
        ];
    }
}
