<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageMenu\Find;

use App\Application\Actions\ConfigPageMenu\ConfigPageMenuAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindAllConfigPageMenuAction extends ConfigPageMenuAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $configPageMenu = $this->configPageMenuRepository->findAll();
        $this->logger->info("查找数据 `config_page_menu`-`*`");
        return $this->respondWithData($configPageMenu);
    }
}
