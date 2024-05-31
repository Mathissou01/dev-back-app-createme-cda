<?php

namespace Database\Factories;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->word,
            'category_id' => 1, // ou utilisez `Category::factory()` si vous avez une factory pour les catégories
            'unit_id' => 1, // ou utilisez `Unit::factory()` si vous avez une factory pour les unités
            'product_code' => $this->faker->unique()->numerify('P######'),
            'stock' => $this->faker->numberBetween(1, 100),
            'buying_price' => $this->faker->numberBetween(1, 100),
            'selling_price' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence, // Ajoutez cette ligne
            'small_description' => $this->faker->sentence, // Ajoutez cette ligne
            'product_image' => null, // ou fournissez une valeur par défaut si nécessaire
            'isActive' => true,
        ];
    }
}
