<?php

namespace App\Tests\Functional\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends WebTestCase
{
    public function testCreateUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();
        
        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');

        // Get form
        $submitButton = $crawler->selectButton('Ajouter');
        $form = $submitButton->form();

        $form["user[username]"] = "Zita test";
        $form["user[password][first]"] = "test";
        $form["user[password][second]"] = "test";
        $form["user[email]"] = "zita@test.fr";
        $form["user[roles][]"] = "ROLE_USER";

        // Send form
        $client->submit($form);

        // Check status code
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $client->followRedirect();

        // Check flash message
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! L'utilisateur a bien été ajouté."
        );
    }
}
