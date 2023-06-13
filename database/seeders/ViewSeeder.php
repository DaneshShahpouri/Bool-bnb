<?php

namespace Database\Seeders;

use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {

            $view = new View();

            $view->apartment_id = $faker->numberBetween(1, 5);
            $view->ip_address = $faker->Ipv4();
            $view->view_date = $faker->dateTime('now');

            $view->save();
        }
    }
}
