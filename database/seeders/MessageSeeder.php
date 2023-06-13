<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 6; $i++) {

            $message = new Message();

            $message->apartment_id = $faker->numberBetween(1, 3);
            $message->username = $faker->userName();
            $message->content = $faker->sentence(50, true);
            $message->email = $faker->email();

            $message->save();
        }
    }
}
