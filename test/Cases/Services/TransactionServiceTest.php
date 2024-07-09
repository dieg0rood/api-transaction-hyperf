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
use App\Model\User;
use App\Service\TransactionService;
use App\ValueObject\Amount;
use Faker\Factory;
use HyperfTest\Cases\AbstractTest;

use function Hyperf\Support\make;

/**
 * @internal
 * @coversNothing
 */
class TransactionServiceTest extends AbstractTest
{
    private TransactionService $transactionService;

    public function setUp(): void
    {
        $this->transactionService = make(TransactionService::class);
        $this->faker = Factory::create();

        parent::setUp();
    }

    public function testCreateWithSuccess()
    {
        $this->makePersonalUser(10000, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makePersonalUser(10000, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $amount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $transaction = $this->transactionService->create(
            sender: $senderEntity,
            receiver: $receiverEntity,
            amount: $amount
        );

        $this->assertEquals($senderEntity->getId(), $transaction->getSenderId());
        $this->assertEquals($receiverEntity->getId(), $transaction->getReceiverId());
        $this->assertEquals($amount->toInt(), $transaction->getValue()->toInt());
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
