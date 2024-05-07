<?php

namespace Database\Seeders;

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
            ['name' => 'Customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Insurance Provider', 'created_at' => now(), 'updated_at' => now()],
            // Add more roles if needed
        ]);
    }
}
