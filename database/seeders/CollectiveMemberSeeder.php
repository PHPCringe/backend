<?php

namespace Database\Seeders;

use App\Models\Collective;
use App\Models\CollectiveMember;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CollectiveMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $users = User::get();
        $collectives = Collective::get();
        for ($i = 1; $i <= 200; $i++) {
            CollectiveMember::create([
                'collective_id' => $collectives[rand(0,  $collectives->count() - 1)]->id,
                'user_id' => $users[rand(0,  $users->count() - 1)]->id,
                'role' => $faker->randomElement(['admin', 'member']),
            ]);
        }
    }
}
