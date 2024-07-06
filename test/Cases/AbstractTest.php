<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use App\Database\Schema;
use Hyperf\DbConnection\Db;
use Hyperf\Testing\TestCase;
use HyperfTest\Traits\ExpectsTrait;

/**
 * @internal
 * @coversNothing
 */

/**
 * Class AbstractTest.
 * @method get($uri, $data = [], $headers = [])
 * @method post($uri, $data = [], $headers = [])
 * @method postWithStatusCode($uri, $data = [], $headers = [])
 * @method json($uri, $data = [], $headers = [])
 * @method file($uri, $data = [], $headers = [])
 * @method request($method, $path, $options = [])
 */
abstract class AbstractTest extends TestCase
{
    use ExpectsTrait;
    public function getData($response) {
        return json_decode($response->getBody()->getContents(), true);
    }
    public function setUp(): void
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
}
