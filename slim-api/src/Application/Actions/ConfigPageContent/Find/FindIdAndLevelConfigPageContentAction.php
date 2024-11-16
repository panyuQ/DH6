<?php
declare(strict_types=1);


namespace App\Application\Actions\ConfigPageContent\Find;

use App\Application\Actions\ConfigPageContent\ConfigPageContentAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindIdAndLevelConfigPageContentAction extends ConfigPageContentAction
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

        $result = $this->configPageContentRepository->findIdAndLevel();

        if (!$result) {
            return $this
                ->respondWithData(['result' => false, 'message' => '暂未开放此功能']);
        }
        return $this->respondWithData(['result' => true, 'content' => $result]);

    }
}
