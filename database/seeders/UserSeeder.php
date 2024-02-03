<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\facades\hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\User::factory(28)->create();

        \App\Models\User::factory()->create([
            'name' => 'titit',
            'email' => 'admin@titit.com',
            'password' =>  Hash::make('bigtitit'),
            'phone' => '08282828369',
            'roles' => 'STAFF'
        ]);
    }
 }

