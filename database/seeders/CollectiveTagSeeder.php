<?php

namespace Database\Seeders;

use App\Models\Collective;
use Faker\Factory as Faker;
use App\Models\CollectiveTag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollectiveTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $collectives = Collective::get();
        for ($i = 1; $i <= 200; $i++) {
            CollectiveTag::create([
                'collective_id' => rand(1, $collectives->count()),
                'name' => $faker->randomElement(['opensource', 'research', 'technology', 'events']),
            ]);
        }
    }
}
