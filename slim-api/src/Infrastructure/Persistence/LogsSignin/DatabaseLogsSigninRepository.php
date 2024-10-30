<?php
declare(strict_types=1);
// src/Infrastructure/Persistence/Users/DatabaseUsersRepository.php
namespace App\Infrastructure\Persistence\LogsSignin;

use App\Domain\LogsSignin\LogsSignin;
use App\Domain\LogsSignin\LogsSigninRepository;

use PDO;
use DateTime;
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
     * @return \App\Domain\LogsSignin\LogsSignin[] 用户对象数组。
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

    public function addOne(int $id, string|null $name, int|null $level, string $ip, DateTime|string|null $time): bool
    {
        if ($time == null || !is_string($time)) {
            $time = (new DateTime())->format('Y-m-d H:i:s');
        } else if ($time instanceof DateTime) {
            $time = $time->format('Y-m-d H:i:s');
        }
        try {
            $stmt = $this->pdo->prepare('INSERT INTO logs_signin (`id`, `name`, `level`, `ip`, `time`) VALUES (:id, :name, :level, :ip, :time)');
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'level' => $level,
                'ip' => $ip,
                'time' => $time
            ]);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}