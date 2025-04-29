<?php

namespace Database\Factories;

use App\Models\Click;
use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClickFactory extends Factory
{
    protected $model = Click::class;

    public function definition()
    {
        return [
            'link_id' => Link::factory(),
            'clicked_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'referrer' => $this->faker->boolean(70)
                ? $this->faker->url
                : null,
            'ip_address' => $this->faker->ipv4,
        ];
    }
}
