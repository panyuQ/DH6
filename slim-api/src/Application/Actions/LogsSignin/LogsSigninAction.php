<?php
declare(strict_types=1);

namespace App\Application\Actions\LogsSignin;

use App\Application\Actions\Action;
use App\Domain\LogsSignin\LogsSigninRepository;
use Psr\Log\LoggerInterface;

abstract class LogsSigninAction extends Action
{
    /**
     * @var LogsSigninRepository
     */
    protected $logsSigninRepository;

    /**
     * @param LoggerInterface $logger
     * @param LogsSigninRepository $usersRepository
     */
    public function __construct(
        LoggerInterface $logger,
        LogsSigninRepository $logsSigninRepository
    ) {
        parent::__construct($logger);
        $this->logsSigninRepository = $logsSigninRepository;
    }
}
