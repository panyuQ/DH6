<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
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
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
    
    $app->get('/api/hello', function (Request $request, Response $response, array $args) {
        $response->getBody()->write(json_encode(['message' => 'Hello, World!']));
        return $response
            ->withHeader('Content-Type', 'application/json');
    });

    $app->get('/api/labs', function (Request $request, Response $response, array $args) {
        $labs = [
            ['id' => 1, 'name' => 'Lab A'],
            ['id' => 2, 'name' => 'Lab B'],
            ['id' => 3, 'name' => 'Lab C']
        ];
        $response->getBody()->write(json_encode($labs));
        return $response
            ->withHeader('Content-Type', 'application/json');
    });
};
