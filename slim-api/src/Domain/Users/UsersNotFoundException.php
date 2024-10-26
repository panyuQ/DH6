<?php
declare(strict_types=1);

namespace App\Domain\Users;

use App\Domain\DomainException\DomainRecordNotFoundException;

class UsersNotFoundException extends DomainRecordNotFoundException
{
    public $message = '您请求的用户不存在。';
}
