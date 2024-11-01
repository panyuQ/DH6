<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Other;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = isset($_SESSION['user']) && isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        $name = $id ? $this->usersRepository->findUserById($id)->getName() : null;
        session_destroy();
        $this->logger->info("用户注销 $id-$name");

        // 关闭会话写入锁
        if (isset($_SESSION)) {
            session_write_close();
        }
        return $this
            ->respondWithData(['result' => true, 'message' => '注销成功']);
    }

}