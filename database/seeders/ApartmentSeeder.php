<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 15; $i++) {
            $apartment = new Apartment();

            $apartment->user_id = $faker->numberBetween(1,3);
            $apartment->name = $faker->sentence(3, true);
            $apartment->description = $faker->text(100);
            $apartment->rooms_number = $faker->numberBetween(1, 8);
            $apartment->beds_number = $faker->numberBetween(1, 8);
            $apartment->bathrooms_number = $faker->numberBetween(1, 4);
            $apartment->sqm = $faker->numberBetween(50, 400);
            $apartment->address = $faker->address();
            $apartment->cover_image = $faker->text(30);
            $apartment->isVisible = $faker->numberBetween(0,1);
            $apartment->slug = Str::slug($apartment->name, '-');

            $apartment->save();
        }
    }
}
