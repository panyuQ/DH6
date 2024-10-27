<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;

class FindFeildByIdUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $field =  $this->resolveArg('field');
        $password = $this->usersRepository->findFieldById($id, $field);

        $this->logger->info("查找 `users` 中 `$field` (id: $id)");

        return $this->respondWithData($password);
    }
}
