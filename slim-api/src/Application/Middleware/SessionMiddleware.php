<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware implements Middleware
{

    private $sessionTime;
    public function __construct()
    {
        global $settings;
        $this->sessionTime = $settings->get('sessionTime');
    }
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {

        if (session_status() == PHP_SESSION_NONE) {
            // 设置会话的最大生存时间（单位：秒）
            ini_set('session.gc_maxlifetime', (string) $this->sessionTime);

            // 设置会话 cookie 的过期时间（单位：秒）
            session_set_cookie_params([
                'lifetime' => $this->sessionTime,
                'path' => '/',
                'domain' => '', // 你的域名，如果需要的话
                'secure' => true, // 是否仅通过 HTTPS 传输
                'httponly' => true, // 是否禁止 JavaScript 访问
                'samesite' => 'Lax' // SameSite 属性
            ]);
            session_start();
        }

        // 重置会话ID
        session_regenerate_id(true);
        
        // 更新最后活动时间
        $_SESSION['last_activity'] = time();

        // 检查会话是否过期
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $this->sessionTime)) {
            // 会话过期，销毁会话
            session_unset();
            session_destroy();
            // 返回会话过期的响应
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('会话已经过期');
            return $response->withStatus(401);
        }

        // 将会话数据添加到请求属性中
        $request = $request->withAttribute('session', $_SESSION);


        // 更新会话数据
        if (isset($_SESSION)) {
            session_write_close();
        }

        return $handler->handle($request);
    }
}