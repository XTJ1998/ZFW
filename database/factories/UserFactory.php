<?php


use App\Models\User;
use Faker\Generator as Faker;

// 生成模拟数据的工厂格式
$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'truename' => $faker->name(),
        'password' => bcrypt('admin888'),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'sex' => ['先生','女士'][rand(0,1)]
    ];
});

