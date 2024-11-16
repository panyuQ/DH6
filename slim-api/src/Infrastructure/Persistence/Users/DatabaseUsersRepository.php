<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Users;

use App\Domain\Users\UsersRepository;
use App\Domain\Users\Users;
use PDO;

/**
 * 数据库用户仓库类，实现 UsersRepository 接口。
 */
class DatabaseUsersRepository implements UsersRepository
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
     * 获取所有用户。
     *
     * @return Users[] 用户对象数组。
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            $users[] = new Users(
                (int) $row['id'],
                $row['username'],
                $row['password'],
                $row['name'],
                (int) $row['level'],
                $row['last_ip'],
                $row['last_time']
            );
        }

        return $users;
    }

    /**
     * 根据用户 ID 获取用户。
     *
     * @param int $id 用户 ID。
     * @return Users|null 用户对象，如果未找到则返回 null。
     */
    public function findUserById(int $id): ?Users
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Users(
                (int) $row['id'],
                $row['username'],
                $row['password'],
                $row['name'],
                (int) $row['level'],
                $row['last_ip'],
                $row['last_time']
            );
        }

        return null;
    }

    public function findUserByUsernameAndPassword(string $username, string $password): ?Users
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username and password = :password');
        $stmt->execute(['username' => $username, 'password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Users(
                (int) $row['id'],
                $row['username'],
                $row['password'],
                $row['name'],
                (int) $row['level'],
                $row['last_ip'],
                $row['last_time']
            );
        }

        return null;
    }

    /**
     * 根据用户 ID 和字段名获取指定字段的值。
     *
     * @param int $id 用户 ID。
     * @param string $field 字段名。
     * @return string|int|null 字段值，如果未找到则返回 null。
     */
    public function findFieldById(int $id, string $field): mixed
    {
        $sql = "SELECT `$field` FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row[$field] : null;
    }

    public function findHighestLevel(): int|null
    {
        $stmt = $this->pdo->prepare('SELECT MAX(level) AS max_level FROM users');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['max_level'] : null;
    }

    public function contrastField(int $id, string $field, string $fieldValue): bool
    {
        // 查询用户字段值
        $sql = "SELECT `$field` FROM users WHERE id = :id AND `$field` = :fieldValue";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'fieldValue' => $fieldValue]);

        // 获取查询结果
        $result = $stmt->fetch();

        // 检查查询结果是否存在
        if ($result) {
            return true;
        }

        return false;
    }
    public function updateLastTime(int $id): int
    {
        $stmt = $this->pdo->prepare('UPDATE users SET last_time = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}