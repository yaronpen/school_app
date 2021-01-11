<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Teacher::class, function (Faker $faker) {
  return [
    "username" => $faker->unique()->firstName,
    "email" => $faker->unique()->safeEmail,
    "password" => "123456",
    "fullname" => $faker->name
  ];
});
