<?php
declare(strict_types=1);

namespace App\Application\Actions\LogsSignin;

use Psr\Http\Message\ResponseInterface as Response;

class FindAllLogsSigninAction extends LogsSigninAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->logsSigninRepository->findAll();

        $this->logger->info("展示 `logs_signin`");

        return $this->respondWithData($users);
    }
}
