<?php

namespace App\Tests\Functional\Form;

use App\Tests\Helper\LoginUser;

class TaskTypeTest extends LoginUser
{
    public function testSomething(): void
    {
        $this->loginAUser();

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        $this->assertEquals(1, $crawler->filter('input[name="task[title]"]')->count());
        $this->assertEquals(1, $crawler->filter('textarea[name="task[content]"]')->count());
        $this->assertEquals(1, $crawler->filter('button')->count());
    }
}
