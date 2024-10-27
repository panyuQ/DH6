<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;

class UserUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $user = $this->usersRepository->findUserById($id);

        $this->logger->info("查找 `users` (id: $id)");

        return $this->respondWithData($user);
    }
}
