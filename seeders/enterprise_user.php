<?php

declare(strict_types=1);

use App\Enum\UserTypesEnum;
use Hyperf\Database\Model\Factory as FactoryModel;
use Hyperf\Database\Seeders\Seeder;
use App\Model\User;
use App\Model\Wallet;
use Faker\Factory;
use Faker\Generator;

class EnterpriseUser extends Seeder
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

        $user = $factory->of(User::class)->create([
            'type' => UserTypesEnum::Enterprise->value,
        ]);

        $factory->of(Wallet::class)->create([
            'user_id' => $user->id,
        ]);
    }
}