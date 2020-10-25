<?php

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'desn' => $faker->word,
        'pic' => '/uploads/article/' . rand(1, 6) . '.jpg',
        'body' => $faker->text
    ];
});
