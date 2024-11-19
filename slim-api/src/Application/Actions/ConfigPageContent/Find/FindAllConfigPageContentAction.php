<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageContent\Find;

use App\Application\Actions\ConfigPageContent\ConfigPageContentAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindAllConfigPageContentAction extends ConfigPageContentAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $configPageContent = $this->configPageContentRepository->findAll();
        $this->logger->info("查找数据 `config_page_content`-`*`");
        return $this->respondWithData($configPageContent);
    }
}
