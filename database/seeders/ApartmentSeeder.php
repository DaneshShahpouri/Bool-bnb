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
        for ($i = 0; $i < 5; $i++) {
            $apartment = new Apartment();

            // $apartment->user_id = 1;
            $apartment->name = $faker->sentence(3, true);
            $apartment->description = $faker->text(100);
            $apartment->rooms_number = $faker->numberBetween(1, 8);
            $apartment->beds_number = $faker->numberBetween(1, 8);
            $apartment->bathrooms_number = $faker->numberBetween(1, 4);
            $apartment->sqm = $faker->numberBetween(50, 400);
            $apartment->address = $faker->text(40);
            $apartment->latitude = $faker->latitude(-90, 90);
            $apartment->longitude = $faker->longitude(-180, 180);
            $apartment->cover_image = $faker->text(30);
            $apartment->isVisible = 1;
            $apartment->slug = Str::slug($apartment->name, '-');

            $apartment->save();
        }
    }
}
