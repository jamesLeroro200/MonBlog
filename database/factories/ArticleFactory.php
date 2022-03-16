<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'meta_description' => $this->faker->sentence(6, true),
            'meta_keywords' => implode(',', $this->faker->words(3, false)),
            'sumary' => $this->faker->paragraph(4, true),
            'body' => $this->faker->paragraph(8, true),
            'active' => true,
        ];
    }
}
