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

    public function findAll(): array
    {

        $sql = 'SELECT * FROM config_page_content ORDER BY id ASC, level ASC';
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = new ConfigPageContent(
                (int) $row['id'],
                (int) $row['level'],
                $row['data'],
            );
        }

        return $result;
    }

public function findAllById(int $id): array{
    
    $sql = 'SELECT * FROM config_page_content WHERE id = :id ORDER BY level ASC';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    foreach ($rows as $row) {
        $result[] = new ConfigPageContent(
            (int) $row['id'],
            (int) $row['level'],
            $row['data'],
        );
    }

    return $result;
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

    public function findOneByIdAndLevel(int $id, int $level): ?ConfigPageContent
    {

        // 构建 SQL 查询，查找不大于 $level 的最大 level 的记录
        $sql = 'SELECT * FROM config_page_content 
            WHERE id = :id AND level = :level';

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

    public function findIdAndLevel(): ?array
    {
        // 查询所有唯一的 id 值
        $sqlId = "SELECT DISTINCT id FROM config_page_content";
        $stmtId = $this->pdo->prepare($sqlId);

        // 查询所有唯一的 level 值
        $sqlLevel = "SELECT DISTINCT level FROM config_page_content";
        $stmtLevel = $this->pdo->prepare($sqlLevel);

        // 执行查询
        if ($stmtId->execute() && $stmtLevel->execute()) {
            // 获取所有 id 结果
            $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);
            $ids = array_column($resultsId, 'id');

            // 获取所有 level 结果
            $resultsLevel = $stmtLevel->fetchAll(PDO::FETCH_ASSOC);
            $levels = array_column($resultsLevel, 'level');

            // 返回结果
            return [
                'id' => $ids,
                'level' => $levels
            ];
        } else {
            // 查询执行失败时返回 null
            return null;
        }
    }
}