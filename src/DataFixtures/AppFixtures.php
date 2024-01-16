<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $user = new User();
        $user->setUsername('Zita')
                ->setEmail('zita@test.fr')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->userPasswordHasher->hashPassword($user, "test"));
        $manager->persist($user);

        // A user for tests
        $user = new User();
        $user->setUsername('Maya')
                ->setEmail('maya@test.fr')
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->userPasswordHasher->hashPassword($user, "test"));
        $manager->persist($user);

        //  Users
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername($this->faker->name())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->userPasswordHasher->hashPassword($user, "test"));

            $users[] = $user;
            $manager->persist($user);
        }

        // Tasks
        for ($i = 0; $i < 5; $i++) {
            $task = new Task;
            $task->setTitle(ucwords($this->faker->word()));
            $task->setContent(substr($this->faker->text(), 0, 50));
            $task->setUser($users[mt_rand(0, count($users) - 1)]);
            $manager->persist($task);
        }

        // Tasks - anonym
        for ($i = 0; $i < 5; $i++) {
            $task = new Task;
            $task->setTitle(ucwords($this->faker->word()));
            $task->setContent(substr($this->faker->text(), 0, 50));
            $manager->persist($task);
        }

        // Find Maya
        $mayaUser = $manager->getRepository(User::class)->findOneBy(['username' => 'Maya']);

        // Tasks for Maya
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->setTitle(ucwords($this->faker->word()));
            $task->setContent(substr($this->faker->text(), 0, 50));
            $task->setUser($mayaUser);
            $manager->persist($task);
        }

        $manager->flush();
    }
}
