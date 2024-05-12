<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insert default user roles
        DB::table('user_roles')->insert([
            [
                'name' => UserRole::ROLE_CUSTOMER,
                'title' => 'Customer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => UserRole::ROLE_INSURANCE_PROVIDER,
                'title'      => 'Insurance Provider',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => UserRole::ROLE_ADMIN,
                'title' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more roles if needed
        ]);
    }
}
