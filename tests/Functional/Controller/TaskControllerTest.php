<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Task;
use App\Tests\Helper\LoginUser;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends LoginUser
{
    public function testCreateTaskAnonym(): void
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        // Get and Fill in the form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'New title';
        $form['task[content]'] = 'New content';

        // Submit the form
        $this->client->submit($form);

        // Assert that the user is created successfully
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        $this->assertRouteSame('task_list');

         $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! La tâche a été bien été ajoutée."
        );
    }

    public function testCreateTaskIdentified(): void
    {
        $this->loginAdminUser();

        // Get the user from the security token
        $user = $this->client->getContainer()->get('security.token_storage')->getToken()->getUser();

        // Set user for task
        $task = new Task();
        $task->setUser($user);

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        // Get and Fill in the form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'New title';
        $form['task[content]'] = 'New content';

        // Submit the form
        $this->client->submit($form);

        // Assert that the user is created successfully
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        $this->assertRouteSame('task_list');

         $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! La tâche a été bien été ajoutée."
        );
    }

    public function testEditTask(): void
    {
        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $this->assertResponseIsSuccessful();

        // Get and Fill in the form
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'New title';
        $form['task[content]'] = 'New edited content';

        // Submit the form
        $this->client->submit($form);

        // Assert that the user is modified successfully
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        $this->assertRouteSame('task_list');

        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! La tâche a bien été modifiée."
        );
    }

    public function testDeleteTask(): void
    {
        $this->loginAdminUser();

        // Get the user from the security token
        $user = $this->client->getContainer()->get('security.token_storage')->getToken()->getUser();
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $task = $entityManager->getRepository(Task::class)->findOneBy(['user' => $user]);
        $taskId = $task->getId();

        $this->client->request('GET', "/tasks/{$taskId}/delete");

        // Assert that the user is deleted successfully
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        $this->assertRouteSame('task_list');

        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            "Superbe ! La tâche a bien été supprimée."
        );
    }

    public function testToggleTask(): void
    {
        // Get task
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $task = $entityManager->getRepository(Task::class)->findOneBy(['id' => 1]);
        $isDoneBefore = $task->isDone();

        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();
        $this->assertRouteSame('task_list');

        $task = $entityManager->getRepository(Task::class)->findOneBy(['id' => 1]);
        $isDoneAfter = $task->isDone();

        $this->assertNotEquals($isDoneBefore, $isDoneAfter);
    }

}
