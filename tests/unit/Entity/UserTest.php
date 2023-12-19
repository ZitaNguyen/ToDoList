<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function getEntity(): User
    {
        return (new User())
            ->setUsername('testUser')
            ->setEmail('testUser@test.fr')
            ->setPassword('test')
            ->setRoles(['ROLE_USER']);
    }

    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity();

        $errors = $container->get('validator')->validate($user);

        $this->assertCount(0, $errors);
    }

    public function testInvalidUsername()
    {
        self::bootKernel();
        $container = static::getContainer();

        $user = $this->getEntity();
        $user->setUsername('');

        $errors = $container->get('validator')->validate($user);
        $this->assertCount(2, $errors);
    }

}
