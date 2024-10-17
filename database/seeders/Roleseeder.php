<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'Admin',
            'permissions'=>'create_task',
            ]);
            Role::factory()->create([
                'name' => 'observer',
                'permissions'=>'comment_task',
            ]);
            Role::factory()->create([
                'name' => 'manger',
                'permissions'=>'manage_task',
            ]);
            Role::factory()->create([
                'name' => 'assinger',
                'permissions'=>'assign_task',
            ]);
            
    }
}
