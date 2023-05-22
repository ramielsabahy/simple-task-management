<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::get();
        foreach ($users as $user)
        {
            $task = new Task();
            $task->title = "Title";
            $task->user_id = $user->id;
            $task->description = "Description";
            $task->due_date = now()->addDays(3);
            $task->save();
        }
    }
}
