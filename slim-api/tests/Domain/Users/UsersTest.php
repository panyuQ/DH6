<?php
declare(strict_types=1);

namespace Tests\Domain\Users;

use App\Domain\Users\Users;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * 提供用户数据的提供者方法。
     *
     * @return array
     */
    public function userProvider(): array
    {
        return [
            [1, 'bill.gates', 1, 'Gates', 'password1', '192.168.1.1', new \DateTime('2024-10-27 03:18:10')],
            [2, 'steve.jobs', 1, 'Jobs', 'password2', '192.168.1.2', new \DateTime('2024-10-27 03:18:11')],
            [3, 'mark.zuckerberg', 1, 'Zuckerberg', 'password3', '192.168.1.3', new \DateTime('2024-10-27 03:18:12')],
            [4, 'evan.spiegel', 1, 'Spiegel', 'password4', '192.168.1.4', new \DateTime('2024-10-27 03:18:13')],
            [5, 'jack.dorsey', 9, 'Dorsey', 'password5', '192.168.1.5', new \DateTime('2024-10-27 03:18:14')],
        ];
    }

    /**
     * 测试 Users 类的 getter 方法。
     *
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $lastIp
     * @param \DateTime $lastTime
     */
    public function testGetters(int $id, string $username, string $firstName, string $lastName, string $password, string $lastIp, \DateTime $lastTime): void
    {
        $user = new Users($id, $firstName . ' ' . $lastName, 1, $username, $password, $lastIp, $lastTime);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals(1, $user->getLevel());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($lastIp, $user->getLastIp());
        $this->assertEquals($lastTime, $user->getLastTime());
    }

    /**
     * 测试 Users 类的 jsonSerialize 方法。
     *
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $lastIp
     * @param \DateTime $lastTime
     */
    public function testJsonSerialize(int $id, string $username, string $firstName, string $lastName, string $password, string $lastIp, \DateTime $lastTime): void
    {
        $user = new Users($id, $firstName . ' ' . $lastName, 1, $username, $password, $lastIp, $lastTime);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $firstName . ' ' . $lastName,
            'level' => 1,
            'username' => $username,
            'password' => $password,
            'last_ip' => $lastIp,
            'last_time' => $lastTime->format(\DateTime::ATOM),
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}