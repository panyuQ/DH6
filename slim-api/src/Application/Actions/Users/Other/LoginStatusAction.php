<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Other;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class LoginStatusAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // 检查会话是否已经启动
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $session = $_SESSION;
        $res = isset($session['user']) && isset($session['user']['level']) && $session['user']['level'] > 0;
        $body = $res ? [
            'id' => $session['user']['id'],
            'name' => $session['user']['name'],
            'level' => $session['user']['level'],
            'result' => true,
            'message' => '已登录',
        ] : ['result' => false, 'message' => '未登录'];

        return $this->respondWithData($body);
    }

}