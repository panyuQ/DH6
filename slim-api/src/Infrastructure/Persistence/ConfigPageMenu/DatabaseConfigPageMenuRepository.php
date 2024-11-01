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


public function findAllByNotGreaterLevel(int $level, ?bool $folder = null): array
{
    // 构建基础查询
    $sql = 'SELECT * FROM config_page_menu WHERE level <= :level';

    // 根据 $folder 参数添加额外条件
    if ($folder !== null) {
        $sql .= ' AND folder ' . ($folder ? 'IS NOT NULL' : 'IS NULL');
    }

    // 添加排序条件
    $sql .= ' ORDER BY id ASC, sort ASC';

    // 准备和执行查询
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['level' => $level]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 构建结果数组
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