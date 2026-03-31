<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'roger@nealix.org'],
            [
                'id'                => Str::uuid(),
                'name'              => 'Admin Fidow',
                'email'             => 'roger@nealix.org',
                'password'          => Hash::make('Fido_èw@klaus@2025!'),
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );
    }
}
