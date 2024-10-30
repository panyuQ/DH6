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
        // 用户是否登录
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return $this
                ->respondWithData(['result' => false, 'message' => '未登录']);
        }
        $id = $_SESSION['user']['id'];
        $user = $this->usersRepository->findUserById($id);
        $this->logger->info("查找数据 `users`-`*` (id = ${id})");

        // 检验用户是否存在
        if (!$user) {
            return $this
                ->respondWithData(['result' => false, 'message' => '用户不存在']);
        }
        $level = $user->getLevel();
        $configPageMenu = $this->configPageMenuRepository->findAllByNotGreaterLevel($level);
        $this->logger->info("查找数据 `config_page_menu`-`*` (level <= ${id})");

        return $this->respondWithData($configPageMenu);
    }
}
