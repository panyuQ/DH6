<?php
declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

// 实例化 PHP-DI 容器构建器
$containerBuilder = new ContainerBuilder();

if (false) { // 在生产环境中应设置为 true
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// 设置时区为中国时区（CST，即东八区，UTC+8）
date_default_timezone_set('Asia/Shanghai');

// 设置应用配置
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// 设置依赖项
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// 设置数据仓库
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// 构建 PHP-DI 容器实例
$container = $containerBuilder->build();

// 实例化应用
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// 注册中间件
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// 注册路由
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// 从全局变量创建请求对象
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// 创建错误处理器
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// 创建关闭处理器
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// 添加路由中间件
$app->addRoutingMiddleware();

// 添加错误中间件
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// 运行应用并发送响应
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);