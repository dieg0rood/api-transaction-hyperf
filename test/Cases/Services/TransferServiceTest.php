<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Services;

use App\Entity\UserEntity;
use App\Exception\Auth\TransactionUnauthorizedException;
use App\Exception\Transaction\TransactionToYourselfException;
use App\Exception\User\EnterpriseUserCannotBePayerException;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\ExternalServices\Service\TransactionAuth\TransactionAuthService;
use App\Model\User;
use App\Service\TransferService;
use App\ValueObject\Amount;
use Faker\Factory;
use HyperfTest\Cases\AbstractTest;
use Mockery;
use function Hyperf\Support\make;

/**
 * @internal
 * @coversNothing
 */
class TransferServiceTest extends AbstractTest
{
    private TransferService $transferService;
    public function setUp(): void
    {
        $this->transferService = make(TransferService::class);
        $this->faker = Factory::create();

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

    public function testTransferPersonalUserToEnterpriseUserWithSuccess()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makeEnterpriseUser($initialBalance, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->transferService->handleTransfer(
            amount:       $transferAmount,
            senderId:     $senderEntity->getId(),
            receiverId:   $receiverEntity->getId()
        );

        $this->assertEquals($initialBalance - round($transferAmount->toInt()), $this->sender->wallet->amount);
        $this->assertEquals($initialBalance + round($transferAmount->toInt()), $this->receiver->wallet->amount);
    }
    public function testTransferPersonalUserToPersonalUserWithSuccess()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makePersonalUser($initialBalance, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->transferService->handleTransfer(
            amount:       $transferAmount,
            senderId:     $senderEntity->getId(),
            receiverId:   $receiverEntity->getId()
        );

        $this->assertEquals($initialBalance - round($transferAmount->toInt()), $this->sender->wallet->amount);
        $this->assertEquals($initialBalance + round($transferAmount->toInt()), $this->receiver->wallet->amount);
    }

    public function testTransferEnterpriseUserToPersonalUserWithException()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makeEnterpriseUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makePersonalUser($initialBalance, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->expectException(EnterpriseUserCannotBePayerException::class);

        $this->transferService->handleTransfer(
            amount: $transferAmount,
            senderId: $senderEntity->getId(),
            receiverId: $receiverEntity->getId()
        );
    }

    public function testTransferPersonalUserToYourselfWithException()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePErsonalUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $receiverEntity = $senderEntity;

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->expectException(TransactionToYourselfException::class);

        $this->transferService->handleTransfer(
            amount: $transferAmount,
            senderId: $senderEntity->getId(),
            receiverId: $receiverEntity->getId()
        );
    }

    public function testTransferWithInsufficientWalletException()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makePersonalUser($initialBalance, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, min: 101)
        );

        $this->expectException(InsufficientWalletAmountException::class);

        $this->transferService->handleTransfer(
            amount: $transferAmount,
            senderId: $senderEntity->getId(),
            receiverId: $receiverEntity->getId()
        );
    }

    public function testTransferWithTransactionUnauthorizedException()
    {
        $this->mockTransactionAuthorizedService(false);

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $senderEntity = $this->userEntity($this->sender);

        $this->makePersonalUser($initialBalance, 'receiver');
        $receiverEntity = $this->userEntity($this->receiver);

        $transferAmount = Amount::fromDecimal(
            $this->faker->randomFloat(nbMaxDecimals: 2, max: 100)
        );

        $this->expectException(TransactionUnauthorizedException::class);

        $transferService = make(TransferService::class, [
            'authService' => $this->getMockTransactionAuthorizedService(false)
        ]);

        $transferService->handleTransfer(
            amount: $transferAmount,
            senderId: $senderEntity->getId(),
            receiverId: $receiverEntity->getId()
        );
    }
}
