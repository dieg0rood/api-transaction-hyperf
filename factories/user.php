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
use App\Enum\UserTypesEnum;
use App\Model\User;
use Faker\Factory as Faker;
use Hyperf\Database\Model\Factory;

$faker = Faker::create('pt_BR');

/* @var Factory $factory */
$factory->define(User::class, function () use ($faker) {
    return [
        'full_name' => $faker->name,
        'document' => str_replace(['.', '-'], '', $faker->cpf),
        'email' => $faker->email,
        'type' => UserTypesEnum::Personal->value,
        'password' => md5($faker->password),
    ];
});
