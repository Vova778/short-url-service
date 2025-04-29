<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Click;
use Illuminate\Database\Seeder;

class ClickSeeder extends Seeder
{
    public function run()
    {
        Link::all()->each(function ($link) {
            $clicksCount = rand(0, 20);
            Click::factory()
                ->count($clicksCount)
                ->create(['link_id' => $link->id]);
        });
    }
}
