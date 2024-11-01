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
        global $settings;

        // 设置会话寿命（例如：30分钟）
        $session_lifetime = $settings->get('sessionTime'); // 30分钟

        // 确保会话已经启动
        if (session_status() === PHP_SESSION_NONE) {
            // 设置会话 cookie 参数
            session_set_cookie_params([
                'lifetime' => $session_lifetime,
                'path' => '/',
                'domain' => '', // 你的域名
                'secure' => true, // 是否只通过 HTTPS 发送 cookie
                'httponly' => true, // 是否禁止 JavaScript 访问 cookie
                'samesite' => 'Lax' // 设置 SameSite 属性
            ]);

            // 设置会话的最大生存时间
            ini_set('session.gc_maxlifetime', $session_lifetime);

            session_start();
        }

        // 重置会话ID
        if (session_status() === PHP_SESSION_ACTIVE) {
            // session_regenerate_id(true);

            // 重置会话的当前生命为生命上限
            setcookie(
                session_name(),
                session_id(),
                time() + $session_lifetime,
                '/',
                '',
                true,
                true
            );
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

        // 更新会话数据
        $id = $user->getId();
        $name = $user->getName();
        $level = $user->getLevel();

        $_SESSION['user']['id'] = $id;
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['level'] = $level;

        // 确保会话数据写入并关闭
        session_write_close();

        $body = [
            'id' => $id,
            'name' => $name,
            'level' => $level,
            'result' => true,
        ];

        return $this->respondWithData($body);
    }
}