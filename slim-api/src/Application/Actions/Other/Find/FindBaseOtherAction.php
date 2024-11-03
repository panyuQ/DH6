<?php
declare(strict_types=1);

namespace App\Application\Actions\Other\Find;

use App\Application\Actions\Other\OtherAction;
use Psr\Http\Message\ResponseInterface as Response;

class FindBaseOtherAction extends OtherAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $ip = $this->request->getServerParams()['REMOTE_ADDR'];
        $time = date('Y-m-d H:i:s',time());
        return $this->respondWithData([
            'result' => true,
            'ip' => $ip,
            'time' => $time
        ]);
    }
}
