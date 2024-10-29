<?php
declare(strict_types=1);

namespace App\Application\Actions\LogsSignin;

use Psr\Http\Message\ResponseInterface as Response;

class AddOneLogsSigninAction extends LogsSigninAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $result = null;
        $message = null;
        $error = [];
        try {
            $formData = $this->getFormData();
            $id = (int) $formData->id ?? null;
            $name = $formData->name ?? null;
            $ip = $this->request->getServerParams()['REMOTE_ADDR'];
            $res = $this->logsSigninRepository->addOne(
                $id,
                $name,
                null,
                $ip,
                null
            );
            $this->logger->info("添加数据 `logs_signin` ($id, $name, $ip)");
            $result = $res;
            $message = '签到成功';
        } catch (\Exception $error) {
            $this->logger->error($error);
            $result = false;
            $message = '签到失败';
        }

        return $this->respondWithData([
            'result' => $result,
            'message' => $message,
        ]+$error);
    }
}
