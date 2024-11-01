<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageContent\Find;

use App\Application\Actions\ConfigPageContent\ConfigPageContentAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindOneByIdAndNotGreaterLevelConfigPageContentAction extends ConfigPageContentAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // 用户是否登录
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return $this
                ->respondWithData(['result' => false, 'message' => '系统繁忙']);
        }
        $id = $_SESSION['user']['id'];
        $level = (int) $this->usersRepository->findFieldById($id, 'level');

        $id = (int) $this->resolveArg('id');
        $this->logger->info("查找数据 `users`-`level` (id = ${id})");

        $configPageContent = $this->configPageContentRepository->findOneByIdAndNotGreaterLevel($id, $level);
        $this->logger->info("查找数据 `config_page_content`-`*` (id = ${id}, level <= ${level}, level DESC , limit = 1)");

        return $this->respondWithData(['result' => true, 'content' => $configPageContent]);

    }
}
