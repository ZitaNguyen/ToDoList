<?php

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginUser extends WebTestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginAdminUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            '_username' => 'Zita',
            '_password' => 'test'
        ]);
    }

    public function loginAUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            '_username' => 'Maya',
            '_password' => 'test'
        ]);
    }

}
