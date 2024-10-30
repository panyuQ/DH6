<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\ConfigPageMenu;

use App\Domain\ConfigPageMenu\ConfigPageMenuRepository;
use App\Domain\ConfigPageMenu\ConfigPageMenu;

use PDO;
/**
 * 数据库用户仓库类，实现 ConfigPageMenuRepository 接口。
 */
class DatabaseConfigPageMenuRepository implements ConfigPageMenuRepository
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


    public function findAllByNotGreaterLevel(int $level): array
    {
        $stam = $this->pdo->prepare('SELECT * FROM config_page_menu WHERE level <= :level');
        $stam->execute(['level' => $level]);
        $rows = $stam->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $result[] = new ConfigPageMenu(
                (int) $row['id'],
                (int) $row['level'],
                $row['folder'],
                $row['name'],
                $row['icon'],
                $row['sort']
            );
        }
        return $result;

    }
}