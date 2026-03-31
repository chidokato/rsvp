<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'tuan.pn92@gmail.com'],
            [
                'name' => 'Tuan PN',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
