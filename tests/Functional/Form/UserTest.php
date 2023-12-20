<?php

namespace App\Tests\Functional\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            '_username' => 'Zita',
            '_password' => 'test'
        ]);
    }

    public function testUserTypeForm(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');

        $this->assertEquals(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][first]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][second]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[email]"]')->count());
        $this->assertEquals(2, $crawler->filter('input[name="user[roles][]"]')->count());

    }
}
