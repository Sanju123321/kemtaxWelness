<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 191)->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('label');
            $table->string('type')->default('text'); // text | number | boolean | select | textarea
            $table->timestamps();
        });

        // Seed defaults
        $defaults = [
            // General
            ['key' => 'company_name',          'value' => 'KemtexWellness',      'group' => 'general',  'label' => 'Company Name',                'type' => 'text'],
            ['key' => 'company_email',          'value' => 'admin@kemtex.com',    'group' => 'general',  'label' => 'Company Email',               'type' => 'text'],
            ['key' => 'company_phone',          'value' => '',                    'group' => 'general',  'label' => 'Company Phone',               'type' => 'text'],
            ['key' => 'min_withdrawal_amount',  'value' => '500',                 'group' => 'financial','label' => 'Min Withdrawal Amount (₹)',   'type' => 'number'],
            ['key' => 'maintenance_mode',       'value' => '0',                   'group' => 'general',  'label' => 'Maintenance Mode',            'type' => 'boolean'],

            // Commission rates
            ['key' => 'commission_l1',          'value' => '15',                  'group' => 'commission','label' => 'Level 1 Commission (%)',      'type' => 'number'],
            ['key' => 'commission_l2',          'value' => '10',                  'group' => 'commission','label' => 'Level 2 Commission (%)',      'type' => 'number'],
            ['key' => 'commission_l3',          'value' => '5',                   'group' => 'commission','label' => 'Level 3 Commission (%)',      'type' => 'number'],
            ['key' => 'commission_l4',          'value' => '5',                   'group' => 'commission','label' => 'Level 4 Commission (%)',      'type' => 'number'],
            ['key' => 'commission_l5_l10',      'value' => '2',                   'group' => 'commission','label' => 'Levels 5–10 Commission (%)',  'type' => 'number'],
            ['key' => 'commission_l11_l20',     'value' => '1',                   'group' => 'commission','label' => 'Levels 11–20 Commission (%)','type' => 'number'],

            // Financial
            ['key' => 'maintenance_fee_percent','value' => '10',                  'group' => 'financial', 'label' => 'Maintenance Fee (%)',         'type' => 'number'],
        ];

        $now = now();
        foreach ($defaults as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        DB::table('settings')->insert($defaults);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
