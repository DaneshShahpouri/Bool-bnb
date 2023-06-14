<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['email' => 'danesh@mail.it', 'password' => 'password', 'name' => 'Danesh', 'surname' => 'shahpouri', 'date_of_birth' => '03-03-2020'],
            ['email' => 'giova@mail.it', 'password' => 'password', 'name' => 'giova', 'surname' => 'shahpouri', 'date_of_birth' => '03-04-2020'],
            ['email' => 'giova3@mail.it', 'password' => 'password', 'name' => 'giova2', 'surname' => 'shahpouri', 'date_of_birth' => '03-05-2020'],
        ];

        foreach ($users as $user) {
            $newuser = new User();

            $newuser->email = $user['email'];
            $newuser->password = Hash::make($user['password']);
            $newuser->name = $user['name'];
            $newuser->surname = $user['surname'];
            $newuser->date_of_birth = null;

            $newuser->save();
        }
    }
}
