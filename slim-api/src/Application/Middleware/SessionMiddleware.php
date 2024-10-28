<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            // 设置会话的最大生存时间（单位：秒）
            ini_set('session.gc_maxlifetime', 3600); // 1小时

            // 设置会话 cookie 的过期时间（单位：秒）
            $cookieLifetime = 3600; // 1小时
            session_set_cookie_params([
                'lifetime' => $cookieLifetime,
                'path' => '/',
                'domain' => '', // 你的域名，如果需要的话
                'secure' => true, // 是否仅通过 HTTPS 传输
                'httponly' => true, // 是否禁止 JavaScript 访问
                'samesite' => 'Lax' // SameSite 属性
            ]);

            // 检查会话是否已经启动
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // 将会话数据添加到请求属性中
            $request = $request->withAttribute('session', $_SESSION);
        }

        return $handler->handle($request);
    }
}