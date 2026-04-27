<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $map = [
            'Plan A' => 'Bronze',
            'Plan B' => 'Silver',
            'Plan C' => 'Gold',
            'Plan D' => 'Platinum',
            'Plan E' => 'Diamond',
        ];

        foreach ($map as $old => $new) {
            DB::table('plans')->where('name', $old)->update(['name' => $new]);
        }

        // Fallback by price in case plan names were edited.
        $fallback = [
            1500 => 'Bronze',
            2500 => 'Silver',
            5000 => 'Gold',
            10000 => 'Platinum',
            20000 => 'Diamond',
        ];

        foreach ($fallback as $price => $name) {
            DB::table('plans')
                ->where('price', $price)
                ->update(['name' => $name]);
        }
    }

    public function down(): void
    {
        $reverse = [
            'Bronze' => 'Plan A',
            'Silver' => 'Plan B',
            'Gold' => 'Plan C',
            'Platinum' => 'Plan D',
            'Diamond' => 'Plan E',
        ];

        foreach ($reverse as $old => $new) {
            DB::table('plans')->where('name', $old)->update(['name' => $new]);
        }
    }
};

