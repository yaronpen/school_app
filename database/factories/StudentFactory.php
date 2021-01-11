<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->firstname,
        'password' => 'superdupersecret',
        'fullname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'grade' => rand(1, 12)
    ];
});
