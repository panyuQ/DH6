<?php
declare(strict_types=1);


namespace App\Application\Actions\Users\Find;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindOneByIdUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $user = $this->usersRepository->findUserById($id);

        $this->logger->info("查找数据 `users`-`*` (id: ${id})");

        return $this->respondWithData($user);
    }
}
