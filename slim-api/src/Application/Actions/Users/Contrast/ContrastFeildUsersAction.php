<?php
declare(strict_types=1);

namespace App\Application\Actions\Users\Contrast;

use App\Application\Actions\Users\UsersAction;
use Psr\Http\Message\ResponseInterface as Response;

class ContrastFeildUsersAction extends UsersAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $field = $this->resolveArg('field');
        $fieldValue = $this->resolveArg('fieldValue');
        $result = $this->usersRepository->contrastField($id, $field, $fieldValue);
        $x = $field == 'password' ? '校验' : '对比';
        $message = $result ? `${x}成功` : `${x}失败`;
        
        $this->logger->info("对比数据[".$result."] `users`-`${field}` (id: ${id}, ${field}: ${fieldValue})");

        return $this->respondWithData(['result' => $result, 'message' => $message]);
    }
}
