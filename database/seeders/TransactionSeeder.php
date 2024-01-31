<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('transactions')->insert([
            'id_brg' => 1,
            'qty' => 2,
            'email' => 'tes@gmail.com',
            'created_at' => now(),
        ]);

        DB::table('transactions')->insert([
            'id_brg' => 2,
            'qty' => 2,
            'email' => 'tes@gmail.com',
            'created_at' => now(),
        ]);
        DB::table('transactions')->insert([
            'id_brg' => 3,
            'qty' => 5,
            'email' => 'tes@gmail.com',
            'created_at' => now(),
        ]);
    }
}
