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

$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'id_document' => $faker->ean8,
        'email' => $faker->safeEmail,
        'password' => bcrypt('123456'),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker->randomElement($array = array ('supervisor', 'employee')),
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {

    return [
        'postcode' => $faker->postcode,
        'name' => $faker->firstName,
        'state' => $faker->firstName,
        'city' => $faker->firstName,
        'lat' => ($faker->numberBetween(1,99)) + ($faker->numberBetween(1,99) * 0.01),
        'lon' => ($faker->numberBetween(1,99)) + ($faker->numberBetween(1,99) * 0.2),
    ];
});

$factory->define(App\Assignment::class, function (Faker\Generator $faker) {

    return [
        'date' => $faker->date('Y-m-d'),
        'time' => $faker->time('H:i:s'),
        'status' => $faker->randomElement($array = array ('pendiente', 'finalizado', 'cancelado')),
        'user_id' => $faker->numberBetween(1,30),
        'location_id' => $faker->numberBetween(1,10)
    ];
});

$factory->define(App\Bill::class, function (Faker\Generator $faker) {

    return [
        'number' => $faker->ean8,
        'client_name' => $faker->name,
        'total' => $faker->numberBetween(50,1500),
        'assigment_id' => $faker->numberBetween(1,50)
    ];
});

$factory->define(App\Detail::class, function (Faker\Generator $faker) {

    return [
        'description' => $faker->word . $faker->word,
        'quantity' => $faker->numberBetween(1,10),
        'unitary_price' => $faker->numberBetween(20,50),
        'bill_id' => $faker->numberBetween(1,50)
    ];
});

