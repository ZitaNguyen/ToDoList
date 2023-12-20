<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function getEntity(): Task
    {
        return (new Task())
            ->setTitle('Test task title')
            ->setContent('Test task content')
            ->setUser(null)
            ->setCreatedAt(new \DateTimeImmutable());
    }

    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $task = $this->getEntity();

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(0, $errors);
    }

    public function testInvalidContent()
    {
        self::bootKernel();
        $container = static::getContainer();

        $task = $this->getEntity();
        $task->setContent('');

        $errors = $container->get('validator')->validate($task);
        $this->assertCount(1, $errors);
    }
}
