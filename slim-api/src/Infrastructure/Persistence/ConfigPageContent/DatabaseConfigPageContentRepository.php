<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\ConfigPageContent;

use App\Domain\ConfigPageContent\ConfigPageContentRepository;
use App\Domain\ConfigPageContent\ConfigPageContent;

use PDO;
/**
 * 数据库用户仓库类，实现 ConfigPageMenuRepository 接口。
 */
class DatabaseConfigPageContentRepository implements ConfigPageContentRepository
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

    public function findOneByIdAndNotGreaterLevel(int $id, int $level = 0): ?ConfigPageContent
    {
        // 构建 SQL 查询，查找不大于 $level 的最大 level 的记录
        $sql = 'SELECT * FROM config_page_content 
            WHERE id = :id AND level <= :level 
            ORDER BY level DESC 
            LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'level' => $level]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // 如果没有找到符合条件的记录，返回 null
        if (!$row) {
            return null;
        }

        // 返回 ConfigPageContent 对象
        return new ConfigPageContent(
            (int) $row['id'],
            (int) $row['level'],
            $row['data']
        );
    }
}