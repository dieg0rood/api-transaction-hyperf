<?php

use Hyperf\Database\Model\Factory;
use Faker\Factory as Faker;
use App\Model\Wallet;
use App\Model\User;

$path = '/var/www/factories/';
$faker = Faker::create('pt_BR');

/* @var Factory $factory */
$factory->define(Wallet::class, function () use ($faker, $path) {
    return  [
        'user_id' => fn() => Factory::construct($faker, $path)->of(User::class)->create()->id,
        'amount' => $faker->randomNumber(6),
    ];
});