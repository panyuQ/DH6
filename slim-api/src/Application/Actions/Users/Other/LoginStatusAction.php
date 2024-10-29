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
        $res = isset($session['user']) && isset($session['user']['id']);
        if (!$res) {
            return $this
                ->respondWithData(['result' => false, 'message' => '未登录']);
        }
        // 获取用户
        $user = $this->usersRepository->findUserById($session['user']['id']);
        // 更新最后登录时间
        $this->usersRepository->updateLastTime($user->getId());
        // 更新会话ID
        $session['user']['id'] = $user->getId();
        
        $body = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'level' => $user->getLevel(),
            'result' => true,
        ];

        return $this->respondWithData($body);
    }

}