<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageContent\Find;

use App\Application\Actions\ConfigPageContent\ConfigPageContentAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindOneByIdAndLevelConfigPageContentAction extends ConfigPageContentAction
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

        $ID = $_SESSION['user']['id'];
        $LEVEL = (int) $this->usersRepository->findFieldById($ID, 'level');
        $this->logger->info("查找数据 `users`-`level` (id = ${ID})");

        $id = (int) $this->resolveArg('id');
        $level = (int) $this->resolveArg('level');

        if ($level > $LEVEL) {
            return $this->respondWithData(['result' => false, 'message' => '权限不足']);
        }

        $configPageContent = $this->configPageContentRepository->findOneByIdAndLevel($id, $level);
        $this->logger->info("查找数据 `config_page_content`-`*` (id = ${id}, level = ${level})");

        if (!$configPageContent) {
            return $this
                ->respondWithData(['result' => false, 'message' => '暂未开放此功能']);
        }
        return $this->respondWithData(['result' => true, 'content' => $configPageContent]);

    }
}
