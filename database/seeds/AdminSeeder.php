<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@trainee.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
