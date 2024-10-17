<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class Userseeder extends Seeder
{  protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'hanen',
            'email' => 'hanenfansa@gmail.com',
            'password'=>static::$password ??= Hash::make('123456789'), 
            'role_id' => '1',
         ]);

         User::factory()->create([
            'name' => 'ahmad',
            'email' => 'ahmadfansa@gmail.com',
            'password'=>static::$password ??= Hash::make('123456789'),
            'role_id' => '2',
         ]);
         User::factory()->create([
            'name' => 'ali',
            'email' => 'alifansa@gmail.com',
            'password'=>static::$password ??= Hash::make('123456789'),
            'role_id' => '3',
         ]);
         User::factory()->create([
            'name' => 'toka',
            'email' => 'tokafansa@gmail.com',
            'password'=>static::$password ??= Hash::make('123456789'),
            'role_id' => '4',
         ]);
    }
}
