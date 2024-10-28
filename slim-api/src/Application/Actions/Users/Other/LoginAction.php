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
            // 开启会话
            session_start();
            // 将用户信息存储在会话中
            $_SESSION['user'] = [
                'id' => $user->getId(),
            ];
            return $this->respondWithData(['result' => true, 'message' => '登录成功']);
        } else {
            return $this->respondWithData(['result' => false, 'message' => '登录失败']);
        }
    }
}