<?php
declare(strict_types=1);

namespace App\Domain\ConfigPageMenu;

use JsonSerializable;

class ConfigPageMenu implements JsonSerializable
{
    private $id;
    private $level;
    private $folder;
    private $name;
    private $icon;
    private $sort;

    public function __construct(
        int $id,
        int $level,
        ?string $folder,
        ?string $name,
        ?string $icon,
        int $sort
    ) {
        $this->id = $id;
        $this->level = $level;
        $this->folder = $folder;
        $this->name = $name;
        $this->icon = $icon;
        $this->sort = $sort;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getFolder(): ?string
    {
        return $this->folder;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function setFolder(?string $folder): void
    {
        $this->folder = $folder;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    // JSON 序列化
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'folder' => $this->folder,
            'name' => $this->name,
            'icon' => $this->icon,
            'sort' => $this->sort,
        ];
    }
}