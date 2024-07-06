<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use App\Database\Schema;
use App\Enum\UserTypesEnum;
use App\ExternalServices\Service\TransactionAuth\TransactionAuthService;
use App\Model\User;
use App\Model\Wallet;
use Hyperf\Context\ApplicationContext;
use Hyperf\DbConnection\Db;
use Hyperf\Event\EventDispatcher;
use Hyperf\Testing\TestCase;
use HyperfTest\Traits\ExpectsTrait;
use Faker\Generator;
use Faker\Factory;
use Hyperf\Database\Model\Factory as FactoryModel;
use Mockery;
use Psr\EventDispatcher\EventDispatcherInterface;

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
        $this->mockEventDispatcher();
        $this->faker = Factory::create();
    }

    private function truncateDatabase(): void
    {
        Schema::disableForeignKeyConstraints();
        $table = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($table as $name) {
            if ($name == 'migrations') {
                continue;
            }
            Db::table($name)->truncate();
        }
        Schema::enableForeignKeyConstraints();
    }

    protected function makePersonalUser($amount, $function): void
    {
        $user = $this->factory(User::class);

        $this->factory(Wallet::class, [
            'user_id' => $user->id,
            'amount' => $amount
        ]);

        $function === 'sender' ? $this->sender = $user : $this->receiver = $user;
    }

    protected function makeEnterpriseUser($amount, $function): void
    {
        $user = $this->factory(User::class, [
            'type' => UserTypesEnum::Enterprise->value
        ]);

        $this->factory(Wallet::class, [
            'user_id' => $user->id,
            'amount' => $amount
        ]);

        $function === 'sender' ? $this->sender = $user : $this->receiver = $user;
    }
    private function factory(string $class, array $data = [])
    {
        $faker = Factory::create('pt_BR');
        $factory = FactoryModel::construct($faker, $this->path);

        return $factory->of($class)->create($data);
    }

    private function mockEventDispatcher(): void
    {
        $mock = Mockery::mock(EventDispatcherInterface::class)
            ->shouldReceive('dispatch')
            ->andReturn()
            ->getMock()
            ->makePartial();

        ApplicationContext::getContainer()->define(
            EventDispatcher::class,
            $mock
        );
    }

    private function mockTransactionAuthorizedService(bool $return = true): void
    {
        $mock = Mockery::mock(TransactionAuthService::class)
            ->shouldReceive('auth')
            ->andReturn($return);

        ApplicationContext::getContainer()->define(
            TransactionAuthService::class,
            fn() => $mock->getMock()->makePartial(),
        );
    }
}
