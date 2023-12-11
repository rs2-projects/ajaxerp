<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->id = 1;
        $admin->type = User::TYPE_ADMIN;
        $admin->role = User::ROLE_SUPERUSER;
        $admin->first_name = 'Admin';
        $admin->last_name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = Carbon::now();
        $admin->password = 123456;
        $admin->status = User::STATUS_ACTIVE;
        $admin->created_by = 1;
        $admin->save();
    }
}
