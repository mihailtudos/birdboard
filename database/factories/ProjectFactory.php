<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker -> sentence(4),
        'description' => $faker->paragraph(8),
        'owner_id'=> factory(App\User::class),
        'notes' => $faker->sentence,
    ];
});
