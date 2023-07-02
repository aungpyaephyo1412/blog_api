<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blogs>
 */
class BlogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $paragraph = fake()->paragraph(150);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' =>$paragraph,
            'excerpt' => Str::words($paragraph,15,'....'),
            'user_id' => rand(1,20),
            'category_id' => rand(1,20),
        ];
    }
}
