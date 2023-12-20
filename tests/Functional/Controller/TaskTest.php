<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TaskTest extends TestCase
{
    private $entityManager;
    private $passwordHasher;

    protected function setUp(): void
    {
        // Set up your dependencies here
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testTask()
    {
        $user = new User();
        $user->setUsername('testTask');
        $user->setEmail('testTask@test.fr');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'test'
        ));
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $task = new Task();
        $task->setTitle('Test task title');
        $task->setContent('Test task content');
        $task->setUser($user);
        $task->setCreatedAt(new \DateTimeImmutable('2023-01-12 23:30:00'));
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $this->assertSame('Test task title', $task->getTitle());
        $this->assertSame('Test task content', $task->getContent());
        $this->assertSame($user, $task->getUser());
        $this->assertFalse($task->isDone());
        $this->assertEquals(new \DateTimeImmutable('2023-01-12 23:30:00'), $task->getCreatedAt());
    }
}
