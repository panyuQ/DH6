<?php
declare(strict_types=1);

namespace App\Domain\LogsSignin;

use App\Domain\DomainException\DomainRecordNotFoundException;

class LogsSigninNotFoundException extends DomainRecordNotFoundException
{
    public $message = '您请求的记录不存在。';
}
