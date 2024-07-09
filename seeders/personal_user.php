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
use Faker\Factory;
use Faker\Generator;
use Hyperf\Database\Model\Factory as FactoryModel;
use Hyperf\Database\Seeders\Seeder;

class PersonalUser extends Seeder
{
    private Generator $faker;

    private string $path = '/var/www/factories/';

    public function __construct()
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function run(): void
    {
        $factory = FactoryModel::construct($this->faker, $this->path);

        $user = $factory->of(User::class)->create();

        $factory->of(Wallet::class)->create([
            'user_id' => $user->id,
        ]);
    }
}
