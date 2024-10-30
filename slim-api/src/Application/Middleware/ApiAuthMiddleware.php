<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Psr7Response;

class ApiAuthMiddleware implements Middleware
{
    private $apiLevel = null;

    private $compiledPatterns = [];


    public function __construct()
    {
        global $settings;
        $this->apiLevel = $settings->get('apiLevel');
    }
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // 获取当前 API 路径
        $api = $request->getUri()->getPath();
        // 获取当前 API 权重
        $weight = $this->getApiWeight($api);

        // 检查会话是否已经启动
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 获取当前用户等级
        $level = isset($_SESSION['user']) && isset($_SESSION['user']['level']) ? $_SESSION['user']['level'] : 0;

        if ($level < $weight) {
            $response = new Psr7Response();
            $response->getBody()->write('权限不足');
            return $response->withStatus(403);
        } else {
            return $handler->handle($request);
        }
    }

    /**
     * 获取 API 路径的权重
     *
     * @param string $api
     * @return int
     */
    private function getApiWeight(string $api): int
    {
        // 缓存匹配结果
        static $cache = [];

        if (isset($cache[$api])) {
            return $cache[$api];
        }

        foreach ($this->apiLevel as $pattern => $weight) {
            // 预编译正则表达式
            if (!isset($this->compiledPatterns[$pattern])) {
                $this->compiledPatterns[$pattern] = "#^" . $pattern . "$#";
            }

            // 使用预编译的正则表达式匹配 API 路径
            if (preg_match($this->compiledPatterns[$pattern], $api)) {
                $cache[$api] = $weight;
                return $weight;
            }
        }

        $cache[$api] = 0;
        return 0;
    }
}