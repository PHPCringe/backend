<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\CollectiveMember;
use App\Models\ContributionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
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
        $adminMember = DB::table('users')->join('collective_members', 'users.id', 'collective_members.user_id')->where('collective_members.role', 'admin')->get();
        $contributionType = ContributionType::get();
        for($i = 0; $i <= 200; $i++) {
            Transaction::create([
                'from_user_id' => $users[rand(0, 74)]->id,
                'to_user_id' => $users[rand(75,  100)]->id,
                'type' =>'donation',
                'issued_by' => 0,
                'contribution_type_id' => $contributionType[rand(0, $contributionType->count() - 1)]->id,
                'title' =>  $faker->sentence($nbWords = 4, $variableNbWords = true),
                'description' =>  $faker->sentence($nbWords = 10, $variableNbWords = true),
                'amount' => $faker->randomNumber(5),
            ]);
        }

        // for($i = 0; $i <= 50; $i++) {
        //     Transaction::create([
        //         'from_user_id' => $users[rand(101, 115)]->id,
        //         'to_user_id' => $users[rand(116,  149)]->id,
        //         'type' => 'expenses,
        //         'issued_by' => $adminMember[rand(0, $adminMember->count() - 1)]->user_id,
        //         'contribution_type_id' => $contributionType[rand(0, $contributionType->count() - 1)]->id,
        //         'title' =>  $faker->sentence($nbWords = 4, $variableNbWords = true),
        //         'description' =>  $faker->sentence($nbWords = 10, $variableNbWords = true),
        //         'amount' => $faker->randomNumber(5),
        //     ]);
        // }
    }
}
