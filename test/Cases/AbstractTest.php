<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use App\Database\Schema;
use App\Enum\UserTypesEnum;
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\Model\User;
use App\Model\Wallet;
use Hyperf\Utils\ApplicationContext;
use Hyperf\DbConnection\Db;
use Hyperf\Testing\TestCase;
use HyperfTest\Traits\ExpectsTrait;
use Faker\Generator;
use Faker\Factory;
use Hyperf\Database\Model\Factory as FactoryModel;
use Mockery;
use Swoole\Http\Status;

/**
 * @internal
 * @coversNothing
 */
abstract class AbstractTest extends TestCase
{
    use ExpectsTrait;

    protected User $sender;
    protected User $receiver;
    private Generator $faker;

    private string $path = '/var/www/factories/';

    public function getData($response) {
        return json_decode($response->getBody()->getContents(), true);
    }
    public function setUp(): void
    {
        $this->truncateDatabase();
        $this->mockNotifyService();
        $this->faker = Factory::create();
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

    protected function makePersonalUser($walletBalance, $function): void
    {
        $user = $this->factory(User::class);

        $this->factory(Wallet::class, [
            'user_id' => $user->id,
            'amount' => $walletBalance
        ]);

        $function === 'sender' ? $this->sender = $user : $this->receiver = $user;
    }

    protected function makeEnterpriseUser($walletBalance, $function): void
    {
        $user = $this->factory(User::class, [
            'type' => UserTypesEnum::Enterprise->value
        ]);

        $this->factory(Wallet::class, [
            'user_id' => $user->id,
            'amount' => $walletBalance
        ]);

        $function === 'sender' ? $this->sender = $user : $this->receiver = $user;
    }
    private function factory(string $class, array $data = [])
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
            fn() => $mock->getMock()->makePartial(),
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
            fn() => $mock->getMock()->makePartial(),
        );
    }

    public function expectExceptionTest(array $response, $expectedErrorMessage = 'Generic Error', int $expectedStatusCode = Status::INTERNAL_SERVER_ERROR): void
    {
        $this->assertIsArray($response);
        $this->assertArrayHasKey('code', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals($response['code'], $expectedStatusCode);
        $this->assertEquals($response['message'], $expectedErrorMessage);
    }
}
