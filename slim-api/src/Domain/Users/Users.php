<?php
declare(strict_types=1);

namespace App\Domain\Users;

use DateTime;
use JsonSerializable;

class Users implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string|null
     */
    private $last_ip;

    /**
     * @var \DateTime|null
     */
    private $last_time;

    /**
     * 构造函数
     *
     * @param int  $id
     * @param string|null  $name
     * @param int       $level
     * @param string    $username
     * @param string    $password
     * @param string|null  $last_ip
     * @param DateTime|string|null  $last_time
     */
    public function __construct(
        int $id,
        string $username,
        string $password,
        string|null $name = null,
        int $level = 0,
        string|null $last_ip = null,
        DateTime|string|null $last_time = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->username = $username;
        $this->password = $password;
        $this->last_ip = $last_ip;
        $this->setLastTime($last_time);
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
     * 获取用户名称
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * 设置用户名称
     *
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 获取用户类型
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * 设置用户类型
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
     * 获取用户账号
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * 设置用户账号
     *
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * 获取用户密码
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * 设置用户密码
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * 获取最后记录IP
     *
     * @return string|null
     */
    public function getLastIp(): ?string
    {
        return $this->last_ip;
    }

    /**
     * 设置最后记录IP
     *
     * @param string|null $last_ip
     * @return self
     */
    public function setLastIp(?string $last_ip): self
    {
        $this->last_ip = $last_ip;
        return $this;
    }

    /**
     * 获取最后记录时间
     *
     * @return DateTime|null
     */
    public function getLastTime(): ?DateTime
    {
        return $this->last_time;
    }

    /**
     * 设置最后记录时间
     *
     * @param DateTime|string|null $last_time
     * @return self
     */
    public function setLastTime($last_time): self
    {
        if (is_null($last_time)) {
            $last_time = new DateTime();
        } else if (is_string($last_time)) {
            $last_time = new DateTime($last_time);
        } else if (!($last_time instanceof DateTime)) {
            throw new \InvalidArgumentException('无效数值 `last_time`');
        }
        $this->last_time = $last_time;
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
            'name' => $this->name,
            'level' => $this->level,
            'username' => $this->username,
            'password' => $this->password,
            'last_ip' => $this->last_ip,
            'last_time' => $this->last_time ? $this->last_time->format('Y-m-d H:i:s') : null,
        ];
    }
}