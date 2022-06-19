<?php

namespace Database\Seeders;

use App\Models\Collective;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 150; $i++) {
            User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->safeEmail,
                'email_verified_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'password' => Hash::make('12345'),
                'type' => $faker->randomElement(['project','collective','event','organization','personal']),
                'avatar_url' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($faker->safeEmail()))) . '?d=identicon'
            ]);
        }
    }
}
