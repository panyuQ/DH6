<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Other;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $formData = $this->getFormData();
        $username = $formData->username ?? '';
        $password = $formData->password ?? '';
        $user = $this->usersRepository->findUserByUsernameAndPassword($username, $password);

        if ($user) {
            // 检查会话是否已经启动
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }   
            $id = $user->getId();
            $name = $user->getName();
            $level = $user->getLevel();
            // 将用户信息存储在会话中
            $_SESSION['user'] = [
                'id' => $id,
                'name' => $name,
                'level' => $level,
            ];
            $this->logger->info("用户-$id `$name` 登录");
            $this->request->withAttribute('session', $_SESSION);
            return $this->respondWithData(['result' => true, 'message' => '登录成功']);
        } else {
            return $this->respondWithData(['result' => false, 'message' => '登录失败']);
        }
    }
    
}