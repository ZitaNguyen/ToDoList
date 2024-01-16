<?php

namespace App\Tests\Functional\Form;

use App\Entity\User;
use App\Tests\Helper\LoginUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTypeTest extends LoginUser
{

    public function testUserTypeFormWhenCreate(): void
    {
        $this->loginAdminUser();

        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');

        $this->assertEquals(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][first]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][second]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[email]"]')->count());
        $this->assertEquals(2, $crawler->filter('input[name="user[roles][]"]')->count());

    }

    public function testUserTypeFormWhenEdit(): void
    {
        $this->loginAdminUser();

        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $users = $entityManager->getRepository(User::class)->findAll();
        $username = $users[0]->getUsername();
        $userId = $users[0]->getId();

        $crawler = $this->client->request('GET', "/users/{$userId}/edit");

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', "Modifier $username");

        $this->assertEquals(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[email]"]')->count());
        $this->assertEquals(2, $crawler->filter('input[name="user[roles][]"]')->count());

    }
}
