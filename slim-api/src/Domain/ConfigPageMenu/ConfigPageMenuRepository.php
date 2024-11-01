<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageMenu;

interface ConfigPageMenuRepository
{
    public function findAllByNotGreaterLevel(int $level, ?bool $folder = null): array;
}
