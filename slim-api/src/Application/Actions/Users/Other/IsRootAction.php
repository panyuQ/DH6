<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Other;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class IsRootAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        // 用户是否登录
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return $this
                ->respondWithData(['result' => false, 'message' => '系统繁忙']);
        }
        $id = $_SESSION['user']['id'];
        $id = $this->usersRepository->findFieldById($id, 'level');
        $this->logger->info("查找数据 `users`-`level` (id = ${id})");
        
        $LEVEL = $this->usersRepository->findHighestLevel();
        $this->logger->info("查找数据 `users`-`level` (MAX)");

        if ($id == $LEVEL) {
            return $this->respondWithData(['result' => true]);
        } else {
            return $this->respondWithData(['result' => false]);
        }
    }

}