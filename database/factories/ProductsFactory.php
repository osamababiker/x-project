<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => 40.5,
        'selling_price' => 39.5,
        'code' => $faker->unique()->phoneNumber,
        'colors' => json_encode($faker->hexcolor,true),
        'size' => json_encode(4),
        'product_specification' => json_encode($faker->text),
        'description' => $faker->text,
        'category_id' => 1,
        'vendor_id' => 1,
        'factory_id' => 1
    ];
});
