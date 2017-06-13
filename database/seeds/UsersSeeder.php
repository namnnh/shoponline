<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Support\Enum\UserStatus;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = User::create([
            'first_name' => 'Vanguard',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => 'admin123',
            'avatar' => null,
            'country_id' => null,
            'status' => UserStatus::ACTIVE
        ]);

        $admin = Role::where('name', 'Admin')->first();

        $user->attachRole($admin);
        $user->socialNetworks()->create([]);
    }
}
