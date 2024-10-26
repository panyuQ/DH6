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
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('DH6 API');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', AllUsersAction::class);
        $group->get('/{id}', UserUsersAction::class);
        $group->get('/{field}/{id}', FeildUsersAction::class);
        $group->get('/{field}/{id}/{fieldValue}', FeildContrastUsersAction::class);
        
    });
    
};
