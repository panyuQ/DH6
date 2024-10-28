<?php
declare(strict_types=1);

namespace App\Domain\LogsSignin;

interface LogsSigninRepository
{
    /**
     * @return LogsSignin[]
     */
    public function findAll(): array;

}
