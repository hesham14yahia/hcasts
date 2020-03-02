<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Series::class, function (Faker $faker) {
    $title = $faker->sentence(5);
    return [
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
        'image_url' => $faker->imageUrl(),
        'description' => $faker->paragraph()
    ];
});
