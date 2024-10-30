<?php
declare(strict_types=1);

namespace App\Application\Actions\ConfigPageMenu;

use App\Application\Actions\Action;
use App\Domain\ConfigPageMenu\ConfigPageMenuRepository;
use App\Domain\Users\UsersRepository;
use Psr\Log\LoggerInterface;

abstract class ConfigPageMenuAction extends Action
{
    /**
     * @var ConfigPageMenuRepository
     */
    protected $configPageMenuRepository;
    /**
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * @param LoggerInterface $logger
     * @param ConfigPageMenuRepository $configPageMenuRepository
     * @param UsersRepository $usersRepository $name
     */
    public function __construct(
        LoggerInterface $logger,
        ConfigPageMenuRepository $configPageMenuRepository,
        UsersRepository $usersRepository
    ) {
        parent::__construct($logger);
        $this->configPageMenuRepository = $configPageMenuRepository;
        $this->usersRepository = $usersRepository;
    }
}
