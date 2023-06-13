<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = [
            ['name' => 'shot', 'price' => 2.99, 'duration' => 24],
            ['name' => 'middle', 'price' => 5.99, 'duration' => 72],
            ['name' => 'long', 'price' => 9.99, 'duration' => 144]
        ];

        foreach ($sponsorships as $sponsorship) {
            $newsponsorship = new Sponsorship();

            $newsponsorship->name = $sponsorship['name'];
            $newsponsorship->price = $sponsorship['price'];
            $newsponsorship->duration = $sponsorship['duration'];

            $newsponsorship->save();
        }
    }
}
