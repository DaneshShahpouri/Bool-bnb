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
            $apartment->latitude = $faker->latitude(-90, 90);
            $apartment->longitude = $faker->longitude(-180, 180);
            $apartment->cover_image = 'https://a0.muscache.com/im/pictures/prohost-api/Hosting-765035845223939533/original/633eea1d-1bd8-4fd9-9367-777b9cf8c929.jpeg?im_w=720';
            $apartment->isVisible = $faker->numberBetween(0,1);
            $apartment->slug = Str::slug($apartment->name, '-');

            $apartment->save();
        }
    }
}
