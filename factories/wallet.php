<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use App\Model\User;
use App\Model\Wallet;
use Faker\Factory as Faker;
use Hyperf\Database\Model\Factory;

$path = '/var/www/factories/';
$faker = Faker::create('pt_BR');

/* @var Factory $factory */
$factory->define(Wallet::class, function () use ($faker, $path) {
    return [
        'user_id' => fn () => Factory::construct($faker, $path)->of(User::class)->create()->id,
        'amount' => $faker->randomNumber(6),
    ];
});
