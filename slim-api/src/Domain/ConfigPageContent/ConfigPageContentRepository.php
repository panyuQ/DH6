<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageContent;

interface ConfigPageContentRepository
{
    /**
     * @return ConfigPageContent
     */
    public function findOneByIdAndNotGreaterLevel(int $id, int $level = 0): ConfigPageContent|null;

}
