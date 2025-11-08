<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'cover_image' => null,
            'price' => $this->faker->numberBetween(10000, 150000),
            'format' => 'print',
            'pages' => $this->faker->numberBetween(50, 500),
            'dimensions' => '20x13cm',
            'language' => 'ID',
            'publisher' => $this->faker->company(),
            'author_info' => $this->faker->text(100),
            'category' => 'General',
            'tags' => 'book',
        ];
    }
}