<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends TestCase
{
    private $entityManager;
    private $passwordHasher;

    protected function setUp(): void
    {
        // Set up your dependencies here
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testUser()
    {
        $user = new User();
        $user->setUsername('testUser');
        $user->setEmail('testUser@test.fr');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'test'
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertSame('testUser', $user->getUsername());
        $this->assertSame($hashedPassword, $user->getPassword());
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('testUser@test.fr', $user->getEmail());
        $this->assertNull($user->eraseCredentials());
    }
}
