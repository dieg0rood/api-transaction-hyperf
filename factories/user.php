<?php

use App\Enum\UserTypesEnum;
use Hyperf\Database\Model\Factory;
use Faker\Factory as Faker;
use App\Model\User;

$faker = Faker::create('pt_BR');

/* @var Factory $factory */
$factory->define(User::class, function () use ($faker) {
    return  [
        'full_name' => $faker->name,
        'document' => str_replace(['.', '-'], '', $faker->cpf),
        'email' => $faker->email,
        'type' => UserTypesEnum::Personal->value,
        'password' => md5($faker->password)
    ];
});