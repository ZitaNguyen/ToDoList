<?php

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataFixturesTest extends WebTestCase
{
    public function testLoadFixtures()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        // Get the EntityManager
        $entityManager = $container->get('doctrine.orm.entity_manager');

        // Clear existing data
        $userRepository = $entityManager->getRepository(User::class);
        $taskRepository = $entityManager->getRepository(Task::class);

        $tasks = $taskRepository->findAll();
        foreach ($tasks as $task) {
            $entityManager->remove($task);
        }

        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $entityManager->remove($user);
        }

        $entityManager->flush();

        // Load the fixtures
        $fixtures = new AppFixtures($container->get(UserPasswordHasherInterface::class));
        $fixtures->load($client->getContainer()->get('doctrine.orm.entity_manager'));

        // Assert that the fixtures have loaded successfully

        // Replace 'User' and 'Task' with your actual entity class names
        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $taskRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        // Assert that the expected number of users and tasks are present in the database
        $this->assertCount(7, $userRepository->findAll());
        $this->assertCount(15, $taskRepository->findAll());
    }
}
