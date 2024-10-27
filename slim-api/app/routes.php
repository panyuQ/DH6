<?php
declare(strict_types=1);

use App\Application\Actions\Users\AllUsersAction;
use App\Application\Actions\Users\UserUsersAction;
use App\Application\Actions\Users\FeildUsersAction;
use App\Application\Actions\Users\FeildContrastUsersAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // CORS 预检 OPTIONS 请求处理
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('DH6 API');
        return $response;
    });
        
    // 获取信息 相关路由
    $app->group('/get/users', function (Group $group) {
        $group->get('', AllUsersAction::class);
        $group->get('/{id}', UserUsersAction::class);
        $group->get('/{field}/{id}', FeildUsersAction::class);
    });

    // 对比信息 相关路由
    $app->group('/contrast/users', function (Group $group) {
        $group->get('/{field}/{id}/{fieldValue}', FeildContrastUsersAction::class);
    });
};