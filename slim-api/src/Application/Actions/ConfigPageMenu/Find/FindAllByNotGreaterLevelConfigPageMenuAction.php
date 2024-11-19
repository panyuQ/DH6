<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageMenu\Find;

use App\Application\Actions\ConfigPageMenu\ConfigPageMenuAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindAllByNotGreaterLevelConfigPageMenuAction extends ConfigPageMenuAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $id = $_SESSION['user']['id'];
        $level = $this->usersRepository->findFieldById($id, 'level');
        $this->logger->info("查找数据 `users`-`level` (id = ${id})");

        $configPageMenu = $this->configPageMenuRepository->findAllByNotGreaterLevel($level);
        $this->logger->info("查找数据 `config_page_menu`-`*` (level <= ${id})");
        if (empty($configPageMenu)) {
            return $this->respondWithData(['result' => false, 'message' =>'数据不存在']);
        }
        return $this->respondWithData(['result' => true, 'data' => $configPageMenu]);
    }
}
