<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User', 
            'email' => 'user@test.com',
            'password' => bcrypt('test12345')
        ]);

        $permissions = Permission::select(['name'])
                        ->get()
                        ->toArray();

        $user->syncPermissions($permissions);
    }
}
