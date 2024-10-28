<?php
declare(strict_types=1);

use App\Domain\Users\UsersRepository;
use App\Infrastructure\Persistence\Users\DatabaseUsersRepository;

use App\Domain\LogsSignin\LogsSigninRepository;
use App\Infrastructure\Persistence\LogsSignin\DatabaseLogsSigninRepository;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // 这里我们将 UsersRepository 接口映射到其数据库实现
    $containerBuilder->addDefinitions([
        UsersRepository::class => \DI\autowire(DatabaseUsersRepository::class),
    ]);
    $containerBuilder->addDefinitions([
        LogsSigninRepository::class => \DI\autowire(DatabaseLogsSigninRepository::class),
    ]);
};