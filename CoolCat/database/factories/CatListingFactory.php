<?php

namespace Database\Factories;

use App\Models\CatBreed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatListing>
 */
class CatListingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['adoption', 'sale']);

        return [
            'user_id' => User::factory(),
            'breed_id' => CatBreed::factory(),
            'name' => fake()->firstName(),
            'gender' => fake()->randomElement(['male', 'female', 'unknown']),
            'birthdate' => fake()->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d'),
            'color' => fake()->randomElement(['white', 'black', 'orange', 'grey', 'tabby', 'calico', 'cream']),
            'description' => fake()->paragraph(),
            'image' => null,
            'type' => $type,
            'price' => $type === 'sale' ? fake()->randomFloat(2, 500, 50000) : null,
            'status' => 'active',
            'is_neutered' => fake()->boolean(30),
            'is_vaccinated' => fake()->boolean(60),
            'views' => fake()->numberBetween(0, 200),
            'province' => fake()->randomElement([
                'Bangkok', 'Chiang Mai', 'Phuket', 'Pattaya', 'Khon Kaen',
                'Nakhon Ratchasima', 'Chon Buri', 'Udon Thani', 'Songkhla',
            ]),
        ];
    }

    public function forSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'sale',
            'price' => fake()->randomFloat(2, 500, 50000),
        ]);
    }

    public function forAdoption(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'adoption',
            'price' => null,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => fake()->randomElement(['reserved', 'sold', 'closed']),
        ]);
    }
}
