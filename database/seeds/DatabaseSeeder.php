<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'client']);

        $user = new App\User();
        $user->password = Hash::make('123456');
        $user->email = 'superadmin@gmail.com';
        $user->name = 'SuperAdmin';
        $user->save();

        $user->assignRole('superadmin');
    }
}
