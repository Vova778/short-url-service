<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Click;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClickSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $countries = [
            'United States',
            'Ukraine',
            'France',
            'Germany',
            'United Kingdom',
            'Switzerland',
            'Unknown',
        ];

        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Unknown'];
        $devices  = ['Desktop', 'Mobile', 'Tablet', 'Other', 'Unknown'];

        Link::all()->each(function ($link) use ($faker, $browsers, $devices, $countries) {
            $clicksCount = rand(100, 200);

            for ($i = 0; $i < $clicksCount; $i++) {
                Click::create([
                    'link_id'    => $link->id,
                    'clicked_at' => $faker->dateTimeBetween('-30 days', '-1 day')->format('Y-m-d H:i:s'),
                    'referrer'   => $faker->optional(0.8)->url,
                    'ip_address' => $faker->ipv4,
                    'browser'    => $faker->randomElement($browsers),
                    'device'     => $faker->randomElement($devices),
                    'country'    => $faker->randomElement($countries),
                    'user_agent' => $faker->userAgent,
                ]);
            }
        });
    }
}
