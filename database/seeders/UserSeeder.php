<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // Tambahkan ini di atas

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        User::truncate();

        $admin = \App\Models\User::create([
            'name'=>'Admin',
            'role'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=> bcrypt('password')
        ]);


        $member = \App\Models\User::create([
            'name'=>'Sample Member',
            'role'=>'member',
            'email'=>'member@gmail.com',
            'password'=> bcrypt('password')
        ]);

        Schema::enableForeignKeyConstraints();
    }
}