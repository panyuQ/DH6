<?php
declare(strict_types=1);

namespace App\Domain\LogsSignin;

interface LogsSigninRepository
{
    /**
     * @return LogsSignin[]
     */
    public function findAll(): array;

    public function addOne(int $id, string|null $name, int|null $level, string $ip, \DateTime|string|null $time): bool;

}
