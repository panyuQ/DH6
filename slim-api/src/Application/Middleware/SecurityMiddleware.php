<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SecurityMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // 处理请求
        $response = $handler->handle($request);

        // 伪装版本号
        $response = $response->withHeader('X-Powered-By', 'PHP/7.0.9');
        $response = $response->withHeader('Server', 'Microsoft-IIS/8.0');
        // $response = $response->withHeader('X-Generator', 'WordPress/5.4.2');

        $response = $response->withHeader('X-Content-Type-Options', 'nosniff');
        $response = $response->withHeader('X-Frame-Options', 'DENY');
        $response = $response->withHeader('X-XSS-Protection', '1; mode=block');
        $response = $response->withHeader('Referrer-Policy', 'no-referrer-when-downgrade');
        $response = $response->withHeader('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");

        return $response;
    }
}