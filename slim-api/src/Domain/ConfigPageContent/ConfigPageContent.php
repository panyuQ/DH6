<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageContent;

use JsonSerializable;

class ConfigPageContent implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string|null
     */
    private $data;


    /**
     * 构造函数
     *
     * @param int|null  $id
     * @param int       $level
     * @param string|null  $data
     */
    public function __construct(
        int $id = null,
        int $level = 0,
        ?string $data = null,
    ) {
        $this->id = $id;
        $this->level = $level;
        $this->data = $data;
    }

    /**
     * 获取用户ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 设置用户ID
     *
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }
    /**
     * 获取权限等级
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * 设置权限等级
     *
     * @param int $level
     * @return self
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }
    /**
     * 获取最后记录IP
     *
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * 设置最后记录IP
     *
     * @param string|null $data
     * @return self
     */
    public function setData(?string $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * JSON序列化
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'data' => $this->data,
        ];
    }
}