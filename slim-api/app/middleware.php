<?php
declare(strict_types=1);

use App\Application\Middleware\ApiAuthMiddleware;
use App\Application\Middleware\SecurityMiddleware;

use Slim\App;

return function (App $app) {
    $app->add(ApiAuthMiddleware::class);
    $app->add(SecurityMiddleware::class);
};