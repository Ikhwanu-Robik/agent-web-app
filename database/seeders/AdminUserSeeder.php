<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'profile_photo' => 'no-photo.jpg',
            'email' => 'johndoe@mail.com',
            'password' => '12345678',
        ]);

        DB::table('users')
            ->where('id', '=', $user->id)
            ->update(['role' => UserRole::ADMIN]);
    }
}
