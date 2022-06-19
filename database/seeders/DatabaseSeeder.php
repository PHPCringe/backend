<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CollectiveSeeder::class);
        $this->call(CollectiveTagSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ContributionTypeSeeder::class);
        $this->call(CollectiveMemberSeeder::class);
        // $this->call(TransactionSeeder::class);
    }
}
