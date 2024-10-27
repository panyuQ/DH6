<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;

class ContrastFeildUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $field =  $this->resolveArg('field');
        $fieldValue =  $this->resolveArg('fieldValue');
        $res = $this->usersRepository->contrastField($id, $field, $fieldValue);

        $this->logger->info("对比 `users` 中 `$field` (id: $id, $field: $fieldValue)");

        return $this->respondWithData($res);
    }
}
