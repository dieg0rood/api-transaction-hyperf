<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Services;

use App\Entity\UserEntity;
use App\Model\User;
use App\Service\WalletService;
use App\ValueObject\Amount;
use HyperfTest\Cases\AbstractTest;
use Faker\Factory;
use function Hyperf\Support\make;

/**
 * @internal
 * @coversNothing
 */
class WalletServiceTest extends AbstractTest
{
    public function setUp(): void
    {
        $this->walletService = make(WalletService::class);
        $this->faker = Factory::create();
        $this->makePersonalUser(10000);

        parent::setUp();
    }

    private function UserEntity(User $user): UserEntity
    {
        return new UserEntity(
            id:         $user->id->toString(),
            full_name:  $user->full_name,
            email:      $user->email,
            type:       $user->type
        );
    }

    public function testWithdrawWithSuccess()
    {
        $entity = $this->userEntity($this->user);
        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->walletService->withdraw($entity, $amount);
        $this->assertEquals(10000 - $amount->toInt(), $this->user->wallet()->first()->amount);
    }




}
