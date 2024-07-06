<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use App\Repository\UserRepository;
use Hyperf\Stringable\Str;
use App\Enum\UserTypesEnum;
use HyperfTest\Helpers\Factory\DocumentGenerator;

class Users extends Seeder
{
    public function run(): void
    {
        UserRepository::create([
            'full_name' => Str::random(),
            'document' => DocumentGenerator::generateDocument(UserTypesEnum::Personal->value),
            'email' => Str::random(),
            'type' => UserTypesEnum::Personal->value,
            'password' => md5(Str::random())
        ]);

        UserRepository::create([
            'full_name' => Str::random(),
            'document' => DocumentGenerator::generateDocument(UserTypesEnum::Enterprise->value),
            'email' => Str::random(),
            'type' => UserTypesEnum::Enterprise->value,
            'password' => md5(Str::random())
        ]);
    }
}
