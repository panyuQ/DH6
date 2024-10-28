<?php
declare(strict_types=1);

// tests/Unit/Infrastructure/Persistence/Users/DatabaseUsersRepositoryTest.php
namespace Tests\Unit\Infrastructure\Persistence\Users;

use App\Infrastructure\Persistence\Users\DatabaseUsersRepository;
use App\Domain\Users\Users;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class DatabaseUsersRepositoryTest extends TestCase
{
    private DatabaseUsersRepository $repository;
    private PDO $pdo;
    private PDOStatement $stmt;

    protected function setUp(): void
    {
        parent::setUp();

        // 模拟PDO对象
        $this->pdo = $this->createMock(PDO::class);
        $this->stmt = $this->createMock(PDOStatement::class);

        $this->pdo->method('prepare')->willReturn($this->stmt); // 修复后的代码
        $this->repository = new DatabaseUsersRepository($this->pdo);
    }

    public function testFindAllReturnsArrayOfUsers(): void
    {
        $expectedUsers = [
            ['id' => 1, 'name' => 'John Doe', 'level' => 1, 'username' => 'johndoe', 'password' => 'hashed_password', 'last_ip' => '127.0.0.1', 'last_time' => '2023-10-01 12:00:00'],
            ['id' => 2, 'name' => 'Jane Smith', 'level' => 2, 'username' => 'janesmith', 'password' => 'hashed_password', 'last_ip' => '127.0.0.1', 'last_time' => '2023-10-01 12:00:00']
        ];

        $this->stmt->expects($this->once())
            ->method('execute')
            ->with([])
            ->willReturn(true);

        $this->stmt->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedUsers);

        $users = $this->repository->findAll();
        $this->assertCount(2, $users);
        $this->assertInstanceOf(Users::class, $users[0]);
    }

    public function testFindUserOfIdReturnsUser(): void
    {
        $expectedUser = ['id' => 1, 'name' => 'John Doe', 'level' => 1, 'username' => 'johndoe', 'password' => 'hashed_password', 'last_ip' => '127.0.0.1', 'last_time' => '2023-10-01 12:00:00'];

        $this->stmt->expects($this->once())
            ->method('execute')
            ->with(['id' => 1])
            ->willReturn(true);

        $this->stmt->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedUser);

        $user = $this->repository->findUserOfId(1);
        $this->assertInstanceOf(Users::class, $user);
        $this->assertEquals(1, $user->getId());
        $this->assertEquals('John Doe', $user->getName());
    }

    public function testFindUserOfIdReturnsNullForNonExistingUser(): void
    {
        $this->stmt->expects($this->once())
            ->method('execute')
            ->with(['id' => 999])
            ->willReturn(true);

        $this->stmt->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(false);

        $user = $this->repository->findUserOfId(999);
        $this->assertNull($user);
    }

    public function testFindFieldOfIdReturnsField(): void
    {
        $expectedField = 'hashed_password';

        $this->stmt->expects($this->once())
            ->method('execute')
            ->with(['field' => 'password', 'id' => 1])
            ->willReturn(true);

        $this->stmt->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(['password' => $expectedField]);

        $field = $this->repository->findFieldOfId(1, 'password');
        $this->assertEquals($expectedField, $field);
    }

    public function testFindFieldOfIdReturnsNullForNonExistingUser(): void
    {
        $this->stmt->expects($this->once())
            ->method('execute')
            ->with(['field' => 'password', 'id' => 999])
            ->willReturn(true);

        $this->stmt->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn(false);

        $field = $this->repository->findFieldOfId(999, 'password');
        $this->assertNull($field);
    }
}