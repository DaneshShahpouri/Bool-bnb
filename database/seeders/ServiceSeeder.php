<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['name' => 'Wi-fi', 'icon' => '<i class="fa-solid fa-wifi"></i>'],
            ['name' => 'Workspace', 'icon' => '<i class="fa-solid fa-laptop-file"></i>'],
            ['name' => 'Reception', 'icon' => '<i class="fa-solid fa-bell-concierge"></i>'],
            ['name' => 'Air conditioning', 'icon' => '<i class="fa-solid fa-fan"></i>'],
            ['name' => 'Heating', 'icon' => '<i class="fa-solid fa-fire"></i>'],
            ['name' => 'Mountain view', 'icon' => '<i class="fa-solid fa-mountain-sun"></i>'],
            ['name' => 'Sea view', 'icon' => '<i class="fa-solid fa-water"></i>'],
            ['name' => 'Pool', 'icon' => '<i class="fa-solid fa-person-swimming"></i>'],
            ['name' => 'Sauna', 'icon' => '<i class="fa-solid fa-house-fire"></i>'],
            ['name' => 'Parking', 'icon' => '<i class="fa-solid fa-square-parking"></i>'],
            ['name' => 'TV', 'icon' => '<i class="fa-solid fa-tv"></i>'],
            ['name' => 'Laundry', 'icon' => '<i class="fa-solid fa-jug-detergent"></i>'],
        ];

        foreach ($services as $service) {
            $newservice = new Service();

            $newservice->name = $service['name'];
            $newservice->icon = $service['icon'];

            $newservice->save();
        };
    }
}
