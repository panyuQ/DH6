<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Domain\Users\UsersRepository;
use Psr\Log\LoggerInterface;

abstract class UsersAction extends Action
{
    /**
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * @param LoggerInterface $logger
     * @param UsersRepository $usersRepository
     */
    public function __construct(LoggerInterface $logger,
                                UsersRepository $usersRepository
    ) {
        parent::__construct($logger);
        $this->usersRepository = $usersRepository;
    }
}
