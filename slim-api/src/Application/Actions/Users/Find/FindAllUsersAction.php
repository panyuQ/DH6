<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Find;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindAllUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->usersRepository->findAll();

        $this->logger->info("查找数据 `users`-`*`");

        return $this->respondWithData($users);
    }
}
