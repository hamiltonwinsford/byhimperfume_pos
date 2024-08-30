<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //super admin
        // $admin = User::updateOrCreate(
        //     [
        //         'name' => 'main admin',
        //         'email' => 'mainadmin@gmail.com',
        //         'password' => bcrypt('123123'),
        //         'role' => 'admin'
        //     ]
        // );

        // $admin->assignRole('admin');

        // //staff
        // $staff = User::updateOrCreate(
        //     [
        //         'name' => 'staff',
        //         'email' => 'staff@gmail.com',
        //         'password' => bcrypt('123123'),
        //         'role' => 'staff'
        //     ]
        // );

        // $staff->assignRole('staff');

        //staff
        $staffMalioboro = User::updateOrCreate(
            [
                'name' => 'staff malioboro',
                'email' => 'staffmalioboro@gmail.com',
                'password' => bcrypt('123123'),
                'role' => 'staff'
            ]
        );

        $staffMalioboro->assignRole('staff');
    }
}
