<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageMenu;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ConfigPageMenuNotFoundException extends DomainRecordNotFoundException
{
    public $message = '您请求的配置项不存在。';
}
