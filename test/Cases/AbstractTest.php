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

namespace HyperfTest\Cases;

use App\Database\Schema;
use App\Enum\ExceptionMessagesEnum;
use App\Enum\UserTypesEnum;
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\ExternalServices\Service\TransactionAuth\TransactionAuthService;
use App\Model\User;
use App\Model\Wallet;
use Faker\Factory;
use Faker\Generator;
use Hyperf\Database\Model\Factory as FactoryModel;
use Hyperf\DbConnection\Db;
use Hyperf\Testing\Http\TestResponse;
use Hyperf\Testing\TestCase;
use Hyperf\Utils\ApplicationContext;
use Mockery;

/**
 * @internal
 * @coversNothing
 */
abstract class AbstractTest extends TestCase
{
    protected User $sender;

    protected User $receiver;

    protected User $user;

    protected Generator $faker;

    private string $path = '/var/www/factories/';

    public function setUp(): void
    {
        $this->truncateDatabase();
        $this->mockNotifyService();
        $this->faker = Factory::create();
    }

    public function expectExceptionTest(
        TestResponse $response,
        ExceptionMessagesEnum $expectedMessage,
        int $expectedStatusCode
    ): void {
        $this->assertEquals($expectedMessage->value, $response->getBody()->getContents());
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
    }

    protected function makePersonalUser($walletBalance, $function = null, $withWallet = true): void
    {
        $user = $this->factory(User::class);

        if ($withWallet) {
            $this->factory(Wallet::class, [
                'user_id' => $user->id,
                'amount' => $walletBalance,
            ]);
        }

        if ($function === 'receiver') {
            $this->receiver = $user;
        } elseif ($function === 'sender') {
            $this->sender = $user;
        } else {
            $this->user = $user;
        }
    }

    protected function makeEnterpriseUser($walletBalance, $function = null, $withWallet = true): void
    {
        $user = $this->factory(User::class, [
            'type' => UserTypesEnum::Enterprise->value,
        ]);

        if ($withWallet) {
            $this->factory(Wallet::class, [
                'user_id' => $user->id,
                'amount' => $walletBalance,
            ]);
        }

        if ($function === 'receiver') {
            $this->receiver = $user;
        } elseif ($function === 'sender') {
            $this->sender = $user;
        } else {
            $this->user = $user;
        }
    }

    protected function factory(string $class, array $data = [])
    {
        $faker = Factory::create('pt_BR');
        $factory = FactoryModel::construct($faker, $this->path);

        return $factory->of($class)->create($data);
    }

    protected function mockTransactionAuthorizedService(bool $return = true): void
    {
        $mock = Mockery::mock(TransactionAuthServiceInterface::class)
            ->shouldReceive('auth')
            ->andReturn($return);

        $container = ApplicationContext::getContainer();
        $container->define(
            TransactionAuthServiceInterface::class,
            fn () => $mock->getMock()->makePartial(),
        );
    }

    protected function mockNotifyService(): void
    {
        $mock = Mockery::mock(NotificationServiceInterface::class)
            ->shouldReceive('notifyTransfer')
            ->andReturnNull();

        $container = ApplicationContext::getContainer();
        $container->define(
            NotificationServiceInterface::class,
            fn () => $mock->getMock()->makePartial(),
        );
    }

    protected function getMockTransactionAuthorizedService(bool $return = true): TransactionAuthService
    {
        return Mockery::mock(TransactionAuthService::class)
            ->shouldReceive('auth')
            ->andReturn($return)
            ->getMock()
            ->makePartial();
    }

    private function truncateDatabase(): void
    {
        Schema::disableForeignKeyConstraints();
        $table = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableNames();

        foreach ($table as $name) {
            if ($name == 'migrations') {
                continue;
            }
            Db::table($name)->truncate();
        }
        Schema::enableForeignKeyConstraints();
    }
}
