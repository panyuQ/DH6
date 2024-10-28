<?php
declare(strict_types=1);
// src/Infrastructure/Persistence/Users/DatabaseUsersRepository.php
namespace App\Infrastructure\Persistence\LogsSignin;

use App\Domain\LogsSignin\LogsSigninRepository;
use App\Domain\LogsSignin\LogsSignin;
use PDO;

/**
 * 数据库用户仓库类，实现 UsersRepository 接口。
 */
class DatabaseLogsSigninRepository implements LogsSigninRepository
{
    /**
     * PDO 实例，用于数据库操作。
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * 构造函数，注入 PDO 实例。
     *
     * @param PDO $pdo PDO 实例。
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 获取所有签到记录。
     *
     * @return LogsSignin[] 用户对象数组。
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM logs_signin');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            $users[] = new LogsSignin(
                (int) $row['id'],
                $row['name'],
                (int) $row['level'],
                $row['ip'],
                $row['time']
            );
        }

        return $users;
    }

}