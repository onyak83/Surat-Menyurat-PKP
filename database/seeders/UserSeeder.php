<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'                => Str::uuid()->toString(),
            'name'              => 'Administrator',
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('admin123'),
            'role_id'           => '1',
        ]);

        User::create([
            'id'                => Str::uuid()->toString(),
            'name'              => 'Operator',
            'email'             => 'operator@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('operator123'),
            'role_id'           => '2',
        ]);
    }
}
