<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIfLoginIsSuccessful(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            '_username' => 'Zita',
            '_password' => 'test'
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        $this->assertRouteSame('homepage');
    }

    public function testIfLoginFailedWithWrongPassword(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            '_username' => 'Zita',
            '_password' => 'password'
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        $this->assertRouteSame('app_login');

        $this->assertSelectorTextContains("div.alert-danger", "Invalid credentials.");
    }
}
