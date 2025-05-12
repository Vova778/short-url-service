<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('statuses')->insert([
            [
                'name' => 'active',
                'label' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'expired',
                'label' => 'Expired',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'disabled',
                'label' => 'Disabled',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'banned',
                'label' => 'Banned',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'warning',
                'label' => 'Warning',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

