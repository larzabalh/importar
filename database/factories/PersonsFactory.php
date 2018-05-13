<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Person::class, function (Faker $faker) {
    return [
      'field_name1' => $faker->name,
      'field_name2' => $faker->name,
      'document_type' => $faker->randomElement(['cuil','cuit']),
      'document' => $faker->randomNumber($nbDigits = null, $strict = false),
      'country_id' =>  App\Models\Country::all()->random()->idCountry,
      'state_id' =>  App\Models\State::all()->random()->idState,
      'zone_id' =>  App\Models\Zone::all()->random()->id,
      'activity_id' => App\Models\Activity::all()->random()->id,
    ];
});
