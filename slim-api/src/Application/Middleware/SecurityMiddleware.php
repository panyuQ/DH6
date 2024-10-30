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

        // 响应头处理
        $response = $this->handleHeader($response);

        return $response;
    }

    private function handleHeader(Response $response): Response
    {
        return $response
            ->withHeader('X-Powered-By', 'PHP/7.0.9')
            ->withHeader('Server', 'Microsoft-IIS/8.0')
            // ->withHeader('X-Generator', 'WordPress/5.4.2')
            ->withHeader('X-Content-Type-Options', 'nosniff')
            ->withHeader('X-Frame-Options', 'DENY')
            ->withHeader('X-XSS-Protection', '1; mode=block')
            ->withHeader('Referrer-Policy', 'no-referrer-when-downgrade')
            ->withHeader('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");

    }

}