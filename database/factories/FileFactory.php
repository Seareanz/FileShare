<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        $extensions = ['pdf', 'jpg', 'png', 'docx', 'xlsx', 'zip', 'txt'];
        $extension = fake()->randomElement($extensions);

        return [
            'user_id' => User::factory(),
            'original_name' => fake()->word().'.'.$extension,
            'stored_name' => Str::random(40).'.'.$extension,
            'path' => 'files/'.fake()->numberBetween(1, 100).'/'.Str::random(40).'.'.$extension,
            'mime_type' => 'application/'.$extension,
            'size' => fake()->numberBetween(10000, 50000000),
            'token' => Str::random(32),
            'download_count' => fake()->numberBetween(0, 100),
            'expires_at' => fake()->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => now()->subDay(),
        ]);
    }

    public function neverExpires(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => null,
        ]);
    }
}
