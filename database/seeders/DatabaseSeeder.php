<?php

namespace Database\Seeders;

use App\Models\CatInquiry;
use App\Models\CatListing;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CatBreedSeeder::class,
        ]);

        // Known test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);

        // 10 random users
        $users = User::factory()->count(10)->create();
        $allUsers = $users->prepend($testUser);

        // 30 products spread across users
        $products = Product::factory()
            ->count(30)
            ->recycle($allUsers)
            ->create();

        // 20 cat listings spread across users
        $listings = CatListing::factory()
            ->count(20)
            ->recycle($allUsers)
            ->create();

        // 15 inquiries — buyer must differ from listing owner
        $listings->each(function (CatListing $listing) use ($allUsers) {
            $buyer = $allUsers->where('id', '!=', $listing->user_id)->random();

            CatInquiry::factory()->create([
                'listing_id' => $listing->id,
                'buyer_id' => $buyer->id,
            ]);
        });

        // 20 reviews on random products — reviewer must differ from product owner
        $products->random(20)->each(function (Product $product) use ($allUsers) {
            $reviewer = $allUsers->where('id', '!=', $product->user_id)->random();

            Review::factory()->create([
                'reviewable_id' => $product->id,
                'reviewable_type' => Product::class,
                'user_id' => $reviewer->id,
            ]);
        });
    }
}
