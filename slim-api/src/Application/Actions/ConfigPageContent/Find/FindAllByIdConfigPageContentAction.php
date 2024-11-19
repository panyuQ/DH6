<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageContent\Find;

use App\Application\Actions\ConfigPageContent\ConfigPageContentAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindAllByIdConfigPageContentAction extends ConfigPageContentAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $configPageContent = $this->configPageContentRepository->findAllById($id);
        $this->logger->info("查找数据 `config_page_content`-`*` ( id: $id )");
        return $this->respondWithData($configPageContent);
    }
}
