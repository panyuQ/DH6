<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // 全局设置对象
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // 在生产环境中应设置为 false
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'DH6-API',
                    // 日志文件路径
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'school_db',
                    'username' => 'school',
                    'password' => '123456',
                    'charset' => 'utf8',
                    'collation' => 'utf_general_ci',
                    'flags' => [
                        PDO::ATTR_PERSISTENT => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ],
                ],
                'sessionTime' => 3600,
                // API 权重 （与用户等级对应）
                'apiLevel' => [
                    '/find/users.*' => 2,
                    '/find/config_page_menu.*' => 1,
                    '/find/config_page_content.*' => 1
                ],
            ]);
        }
    ]);
};