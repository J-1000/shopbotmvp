<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,
        'category_id' => function () {
        	return factory('App\Category')->create()->id;
        },
        'listing_id' => function () {
            return factory('App\Listing')->create()->id;
        }
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Listing::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,
    ];
});
