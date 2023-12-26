<?php

namespace App\Tests\Functional\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTypeTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        $this->assertEquals(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertEquals(1, $crawler->filter('textarea[name="task[content]"]')->count());
        $this->assertEquals(1, $crawler->filter('button')->count());
    }
}
