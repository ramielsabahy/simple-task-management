<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($count = 1; $count <= 3; $count++)
        {
            $user = new User();
            $user->name = "User $count";
            $user->email = "user$count@gmail.com";
            $user->password = Hash::make(123456);
            $user->save();
        }
    }
}
