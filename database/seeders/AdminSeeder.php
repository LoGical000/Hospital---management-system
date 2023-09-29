<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('admins')->delete();
        DB::table('admins')->insert([
            'name'=>'omar',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('123456')
        ]);



    }
}
