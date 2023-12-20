<?php

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
            '_username' => 'Tester',
            '_password' => 'test'
        ]);
    }

    public function testListUser(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

        $this->assertEquals(1, $crawler->filter('table')->count());
        $this->assertEquals(1, $crawler->filter('.btn.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.btn.btn-danger')->count());

    }

    public function testCreateUser(): void
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'New User';
        $form['user[password][first]'] = 'test';
        $form['user[password][second]'] = 'test';
        $form['user[email]'] = 'test@test.fr';

        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $crawler = $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

         $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! L'utilisateur a bien été ajouté."
        );

    }
}
