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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // 检查会话中是否有用户信息
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return $this->respondWithData(['result' => false]);
        }

        // 获取用户
        $user = $this->usersRepository->findUserById($_SESSION['user']['id']);

        if (!$user) {
            return $this->respondWithData(['result' => false]);
        }

        // 更新最后登录时间
        $this->usersRepository->updateLastTime($user->getId());

        // 更新会话ID
        $id = $user->getId();
        $name = $user->getName();
        $level = $user->getLevel();

        $_SESSION['user']['id'] = $id;
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['level'] = $level;

        // 关闭会话写入锁
        if (isset($_SESSION)) {
            session_write_close();
        }


        $body = [
            'id' => $id,
            'name' => $name,
            'level' => $level,
            'result' => true,
        ];

        return $this->respondWithData($body);
    }
}