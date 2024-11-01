<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageContent;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ConfigPageContentNotFoundException extends DomainRecordNotFoundException
{
    public $message = '您请求的页面配置内容不存在。';
}
