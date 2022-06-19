<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collective;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 70; $i++) {
            Collective::create([
                'user_id' => $users[rand(0,  $users->count() - 1)]->id,
                'bio' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'is_profit' => rand(0, 1),
                'description' => $faker->sentence($nbWords = 30, $variableNbWords = true),
                'website' => $faker->url,
                'donation_goal' => $faker->randomNumber(5),
                'twitter' => 'https://twitter.com/' . $users[rand(0,  $users->count() - 1)]->username,
            ]);
        }
    }
}
