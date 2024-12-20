<?php
declare(strict_types=1);

use App\Application\Actions\ConfigPageContent\Find\FindAllConfigPageContentAction;
use App\Application\Actions\ConfigPageContent\Find\FindAllByIdConfigPageContentAction;
use App\Application\Actions\ConfigPageContent\Find\FindOneByIdAndNotGreaterLevelConfigPageContentAction;
use App\Application\Actions\ConfigPageContent\Find\FindOneByIdAndLevelConfigPageContentAction;
use App\Application\Actions\ConfigPageContent\Find\FindIdAndLevelConfigPageContentAction;


use App\Application\Actions\ConfigPageMenu\Find\FindAllByNotGreaterLevelConfigPageMenuAction;


use App\Application\Actions\ConfigPageMenu\Find\FindAllConfigPageMenuAction;
use App\Application\Actions\Users\Contrast\ContrastFeildUsersAction;

use App\Application\Actions\Users\Find\FindAllUsersAction;
use App\Application\Actions\Users\Find\FindFeildByIdUsersAction;
use App\Application\Actions\Users\Find\FindOneByIdUsersAction;

use App\Application\Actions\Users\Other\IsRootAction;
use App\Application\Actions\Users\Other\LoginAction;
use App\Application\Actions\Users\Other\LoginStatusAction;
use App\Application\Actions\Users\Other\LogoutAction;

use App\Application\Actions\LogsSignin\Add\AddOneLogsSigninAction;

use App\Application\Actions\LogsSignin\Find\FindAllLogsSigninAction;

use App\Application\Actions\Other\Find\FindBaseOtherAction;

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
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    });

    // 根路由
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('DH6 API Server');
        return $response;
    });

    // 登录状态检查
    $app->group('/is', function (Group $group) {
        $group->get('/root', IsRootAction::class);
    });

    // 登录相关路由
    $app->group('/login', function (Group $group) {
        $group->post('', LoginAction::class);
        $group->get('/status', LoginStatusAction::class);
    });

    // 退出登录
    $app->group('/logout', function (Group $group) {
        $group->get('', LogoutAction::class);
    });

    // 签到相关路由
    $app->group('/signin', function (Group $group) {
        $group->post('', AddOneLogsSigninAction::class);
    });

    $app->group('/find/other', function (Group $group) {
        $group->get('/base', FindBaseOtherAction::class);
    });

    // 用户信息查找相关路由
    $app->group('/find/users', function (Group $group) {
        $group->get('', FindAllUsersAction::class);
        $group->get('/{id}', FindOneByIdUsersAction::class);
        $group->get('/{field}/{id}', FindFeildByIdUsersAction::class);
    });

    $app->group('/find/config_page_menu', function (Group $group) {
        $group->get('', FindAllByNotGreaterLevelConfigPageMenuAction::class);
        $group->get('/all', FindAllConfigPageMenuAction::class);
    });

    $app->group('/find/config_page_content', function (Group $group) {
        $group->get('/all', FindAllConfigPageContentAction::class);
        $group->get('/id_and_level', FindIdAndLevelConfigPageContentAction::class);
        $group->get('/{id}', FindOneByIdAndNotGreaterLevelConfigPageContentAction::class);
        $group->get('/all/{id}', FindAllByIdConfigPageContentAction::class);
        $group->get('/{id}/{level}', FindOneByIdAndLevelConfigPageContentAction::class);
    });

    // 签到日志查找相关路由
    $app->group('/find/logs_signin', function (Group $group) {
        $group->get('', FindAllLogsSigninAction::class);
    });

    // 用户信息对比相关路由
    $app->group('/contrast/users', function (Group $group) {
        $group->get('/{field}/{id}/{fieldValue}', ContrastFeildUsersAction::class);
    });
};