<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->text,
//            'category_id' => function () {
//                return Category::all()->random();
//            },
//            'user_id' => function () {
//                return User::all()->random();
//            }
            'category_id' => 1,
            'user_id' => 1
        ];
    }

}
