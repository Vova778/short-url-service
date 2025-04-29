<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'short_code' => strtoupper(Str::random(6)),
            //'user_id' => User::factory()->optional()->create()->id,
            'user_id' => User::first()->id,
            'password' => $this->faker->boolean(10)
                ? Hash::make($this->faker->password(6, 12))
                : null,
            'expires_at' => $this->faker->boolean(10)
                ? $this->faker->dateTimeBetween('now', '+30 days')
                : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
