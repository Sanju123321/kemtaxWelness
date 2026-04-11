<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('plans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('plans')->insert([
            [
                'name'       => 'Plan A',
                'price'      => 1500,
                'base_value' => 1000,
                'daily_cap'  => 2000,
                'total_cap'  => 10000,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Plan B',
                'price'      => 3000,
                'base_value' => 2000,
                'daily_cap'  => 5000,
                'total_cap'  => 25000,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Plan C',
                'price'      => 7500,
                'base_value' => 5000,
                'daily_cap'  => 10000,
                'total_cap'  => 50000,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Plan D',
                'price'      => 15000,
                'base_value' => 10000,
                'daily_cap'  => 20000,
                'total_cap'  => 100000,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Plan E',
                'price'      => 30000,
                'base_value' => 20000,
                'daily_cap'  => 50000,
                'total_cap'  => 250000,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
