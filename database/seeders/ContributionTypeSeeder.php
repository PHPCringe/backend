<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Collective;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\ContributionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContributionTypeSeeder extends Seeder
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
        $currencies = Currency::get();
        for ($i = 1; $i <= 200; $i++) {
            ContributionType::create([
                'collective_id' => $collectives[rand(0, $collectives->count() - 1)]->id,
                'name' => $faker->randomElement(['Backer', 'Bronze', 'Medal', 'Sponsor', 'Donation', 'Gold', 'Platinum', 'Diamond']),
                'description' => $faker->sentence($nbWords = 15, $variableNbWords = true),
                'cost' => $faker->randomNumber(5),
                'currency_id' => $currencies[rand(0, $currencies->count() - 1)]->id,
                'type' => $faker->randomElement(['monthly', 'annually', 'onetime']),
                'is_recurring' => $faker->randomElement([0, 1])
            ]);
        }
    }
}
