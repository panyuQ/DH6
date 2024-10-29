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
        session_destroy();
        return $this
            ->respondWithData(['result' => true, 'message' => '注销成功']);
    }

}