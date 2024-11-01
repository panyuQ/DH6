<?php
declare(strict_types=1);

namespace App\Application\Actions\ConfigPageContent;

use App\Application\Actions\Action;
use App\Domain\ConfigPageContent\ConfigPageContentRepository;
use App\Domain\Users\UsersRepository;
use Psr\Log\LoggerInterface;

abstract class ConfigPageContentAction extends Action
{
    /**
     * @var ConfigPageContentRepository
     */
    protected $configPageContentRepository;
    /**
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * @param LoggerInterface $logger
     * @param ConfigPageContentRepository $configPageContentRepository
     * @param UsersRepository $usersRepository $name
     */
    public function __construct(
        LoggerInterface $logger,
        ConfigPageContentRepository $configPageContentRepository,
        UsersRepository $usersRepository
    ) {
        parent::__construct($logger);
        $this->configPageContentRepository = $configPageContentRepository;
        $this->usersRepository = $usersRepository;
    }
}
