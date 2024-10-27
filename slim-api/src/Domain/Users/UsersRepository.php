<?php
declare(strict_types=1);

namespace App\Domain\Users;

interface UsersRepository
{
    /**
     * @return Users[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Users
     * @throws UsersNotFoundException
     */
    public function findUserById(int $id): ?Users;

    public function findFieldById(int $id, string $field): ?string;

    public function fieldContrast(int $id, string $field, string $fieldValue): ?bool;
}
