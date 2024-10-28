<?php
declare(strict_types=1);

use App\Application\Actions\Users\FindAllUsersAction;
use App\Application\Actions\Users\FindOneByIdUsersAction;
use App\Application\Actions\Users\FindFeildByIdUsersAction;
use App\Application\Actions\Users\ContrastFeildUsersAction;
use App\Application\Actions\Users\Other\LoginAction;
use App\Application\Actions\LogsSignin\FindAllLogsSigninAction;
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

    $app->group('/login', function (Group $group) {
        $group->post('', LoginAction::class) ;
    });

    $app->group('/signin', function (Group $group) {
        $group->post('', LoginAction::class) ;
    });
    

    // 查找信息 相关路由
    $app->group('/find/users', function (Group $group) {
        $group->get('', FindAllUsersAction::class);
        $group->get('/{id}', FindOneByIdUsersAction::class);
        $group->get('/{field}/{id}', FindFeildByIdUsersAction::class);
    });
    $app->group('/find/logs_signin', function (Group $group) {
        $group->get('', FindAllLogsSigninAction::class);
    });

    // 对比信息 相关路由
    $app->group('/contrast/users', function (Group $group) {
        $group->get('/{field}/{id}/{fieldValue}', ContrastFeildUsersAction::class);
    });
};