<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collective;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $fakerEn = Faker::create('en_EN');
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => $faker->company,
                'username' => $faker->userName,
                'email' => $faker->safeEmail,
                'email_verified_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'password' => Hash::make('12345'),
                'type' => $faker->randomElement(['project','collective','event','organization']),
                'avatar_url' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($faker->safeEmail()))) . '?d=identicon'
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => $fakerEn->name,
                'username' => Str::slug($fakerEn->userName),
                'email' => $fakerEn->safeEmail,
                'email_verified_at' => $fakerEn->date($format = 'Y-m-d', $max = 'now'),
                'password' => Hash::make('12345'),
                'type' => 'personal',
                'avatar_url' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($fakerEn->safeEmail()))) . '?d=identicon'
            ]);
        }
    }
}
