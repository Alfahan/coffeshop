<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table("users")->insert([
            "name" => "Alfa Corners",
            "email" => "alfa@email.com",
            "password" => Hash::make("alfa"),
            "address" => "Jl. Kesemutan",
            "houseNumber" => "Rumah No. 17",
            "phoneNumber" => "081515815175",
            "city" => "Karawang",
            "roles" => "ADMIN",
        ]);
    }
}
