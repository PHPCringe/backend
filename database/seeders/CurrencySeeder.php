<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::insert([
            'name' => 'USD',
            'symbol' => '$'
        ], [
            'name' => 'IDR',
            'symbol' => 'Rp'
        ]);
    }
}
