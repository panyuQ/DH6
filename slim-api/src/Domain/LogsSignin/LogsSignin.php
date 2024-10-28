<?php
declare(strict_types=1);

namespace App\Domain\LogsSignin;

use DateTime;
use JsonSerializable;

class LogsSignin implements JsonSerializable
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
    private $user_type;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var DateTime|string|null
     */
    private $time;

    /**
     * 构造函数
     *
     * @param int|null  $id
     * @param string|null  $name
     * @param int       $user_type
     * @param string|null  $ip
     * @param DateTime|null  $time
     */
    public function __construct(
        int $id = null,
        ?string $name = null,
        int $user_type = 0,
        ?string $ip = null,
        DateTime|string|null $time = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->user_type = $user_type;
        $this->ip = $ip;
        $this->setTime($time);
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
    public function getUserType(): int
    {
        return $this->user_type;
    }

    /**
     * 设置用户类型
     *
     * @param int $user_type
     * @return self
     */
    public function setUserType(int $user_type): self
    {
        $this->user_type = $user_type;
        return $this;
    }
    /**
     * 获取最后记录IP
     *
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * 设置最后记录IP
     *
     * @param string|null $ip
     * @return self
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * 获取最后记录时间
     *
     * @return DateTime|null
     */
    public function getTime(): DateTime|null
    {
        return $this->time;
    }

    /**
     * 设置最后记录时间
     *
     * @param DateTime|string|null $time
     * @return self
     */
    public function setTime($time): self
    {
        if (is_null($time)) {
            $time = new DateTime();
        } else if (is_string($time)) {
            $time = new DateTime($time);
        } else if (!($time instanceof DateTime)) {
            throw new \InvalidArgumentException('无效数值 `time`');
        }
        $this->time = $time;
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
            'user_type' => $this->user_type,
            'ip' => $this->ip,
            'time' => $this->time ? $this->time->format('Y-m-d H:i:s') : null,
        ];
    }
}