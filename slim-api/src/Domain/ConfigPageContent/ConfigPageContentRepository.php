<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageContent;

interface ConfigPageContentRepository
{
    public function findAll(): array;

    public function findAllById(int $id): array;
    /**
     * @return ConfigPageContent
     */
    public function findOneByIdAndNotGreaterLevel(int $id, int $level = 0): ConfigPageContent|null;

    
    /**
     * @return ConfigPageContent
     */
    public function findOneByIdAndLevel(int $id, int $level): ConfigPageContent|null;

    public function findIdAndLevel(): ?array;
}
