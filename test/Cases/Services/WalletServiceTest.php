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

namespace HyperfTest\Cases\Services;

use App\Entity\UserEntity;
use App\Exception\Repository\WalletDataNotFoundException;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\Model\User;
use App\Service\WalletService;
use App\ValueObject\Amount;
use Faker\Factory;
use HyperfTest\Cases\AbstractTest;

use function Hyperf\Support\make;

/**
 * @internal
 */
class WalletServiceTest extends AbstractTest
{
    private WalletService $walletService;

    public function setUp(): void
    {
        $this->walletService = make(WalletService::class);
        $this->faker = Factory::create();

        parent::setUp();
    }

    public function testWithdrawWithSuccess()
    {
        $this->makePersonalUser(10000);

        $entity = $this->userEntity($this->user);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->walletService->withdraw($entity, $amount);

        $this->assertEquals(10000 - $amount->toInt(), $this->user->wallet()->first()->amount);
    }

    public function testWithdrawWithInsufficientAmountException()
    {
        $this->makePersonalUser(10000);

        $entity = $this->userEntity($this->user);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, min: 101)
        );

        $this->expectException(InsufficientWalletAmountException::class);

        $this->walletService->withdraw($entity, $amount);
    }

    public function testWithdrawWithWalletNotFoundException()
    {
        $this->makePersonalUser(10000, null, false);

        $entity = $this->userEntity($this->user);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, min: 101)
        );

        $this->expectException(WalletDataNotFoundException::class);

        $this->walletService->withdraw($entity, $amount);
    }

    public function testDepositWithSuccess()
    {
        $this->makePersonalUser(10000);

        $entity = $this->userEntity($this->user);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->walletService->deposit($entity, $amount);

        $this->assertEquals(10000 + $amount->toInt(), $this->user->wallet()->first()->amount);
    }

    public function testDepositWithWalletNotFoundException()
    {
        $this->makePersonalUser(10000, null, false);

        $entity = $this->userEntity($this->user);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->expectException(WalletDataNotFoundException::class);

        $this->walletService->deposit($entity, $amount);
    }

    private function UserEntity(User $user): UserEntity
    {
        return new UserEntity(
            userId: $user->id->toString(),
            fullName: $user->full_name,
            email: $user->email,
            type: $user->type
        );
    }
}
