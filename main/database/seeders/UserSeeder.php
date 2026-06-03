<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Abderrahim El Hassouni',
            'email'     => 'courtier@mytaxi.ma',
            'password'  => Hash::make('password'),
            'telephone' => '+212 661 11 22 33',
            'role'      => User::ROLE_COURTIER,
            'email_verified_at' => now(),
        ]);

        $voyageurs = [
            ['name' => 'Sara Bennani',  'email' => 'sara@gmail.ma',  'telephone' => '+212 662 34 56 78'],
            ['name' => 'Youssef Amrani', 'email' => 'youssef@gmail.ma', 'telephone' => '+212 663 45 67 89'],
            ['name' => 'Karim Idrissi',  'email' => 'karim@gmail.ma',  'telephone' => '+212 664 56 78 90'],
            ['name' => 'Fatima Zahra',   'email' => 'fatima@gmail.ma', 'telephone' => '+212 665 67 89 01'],
        ];

        foreach ($voyageurs as $v) {
            User::create(array_merge($v, [
                'password' => Hash::make('password'),
                'role'     => User::ROLE_VOYAGEUR,
                'email_verified_at' => now(),
            ]));
        }
    }
}
