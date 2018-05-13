<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Receipt::class, function (Faker $faker) {
    return [
        'number' => $faker->randomNumber($nbDigits = null, $strict = false),
        'receipt_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'expiration_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'code_ticket' => $faker->randomNumber($nbDigits = null, $strict = false),
        'status_id' => $faker->randomElement([1, 2, 3]),
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = NULL),
        'person_id_relationed' =>  App\Models\Person::all()->random()->id,
        'person_id_owner' =>  1,
        //  'person_id_owner' =>  App\Models\Person::all()->random()->id,
        'retention_type_id' =>  App\Models\RetentionType::all()->random()->id,
        'activity_id' =>  App\Models\Activity::all()->random()->id,
        'zone_id' =>  App\Models\Zone::all()->random()->id,
        //fix this for the relation to correct period_id
        'period_id' =>  App\Models\Person::find(1)->periods->random()->id,
        //period_id' =>  App\Models\Period::all()->where('')->where('')->id,
        'type_receipt_id' =>  App\Models\ReceiptType::all()->random()->id,
        'type_id' =>  App\Models\Type::all()->random()->id,
    ];
});
