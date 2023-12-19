<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testListUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');

        $table = $crawler->filter('table');
        $this->assertEquals(1, count($table));

        $buttonCreateUser = $crawler->filter('.btn.btn-primary');
        $this->assertEquals(1, count($buttonCreateUser));

        $buttonLogOut = $crawler->filter('.btn.btn-danger');
        $this->assertEquals(1, count($buttonLogOut));

    }
}
