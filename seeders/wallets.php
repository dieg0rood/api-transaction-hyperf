<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use App\Repository\WalletRepository;
use App\Repository\UserRepository;

class Wallets extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = UserRepository::findWithoutWallet();
        foreach ($users as $user) {
            WalletRepository::create($user, rand(100, 10000000));
        }
    }
}
