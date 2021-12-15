<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            Book::create([
                'book' => ucwords($faker->words(rand(1, 4), true)),
                'author' => $faker->unique(false)->numberBetween(1, 100),
                'pages' => $faker->unique(true)->numberBetween(100, 1000)
            ]);
        }
    }
}
