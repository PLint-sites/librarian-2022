<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence($nbWords = 6, $variableNbWords = true),
            'owned' => rand(0,1),
            'completed' => rand(0,1),
            'user_id' => 1,
            'writer_id' => rand(1,5),
            'genre_id' => rand(1,10)
        ];
    }
}
