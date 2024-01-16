<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    public function __construct(
        private TaskRepository $taskRepository,
        private EntityManagerInterface $entityManager
    ){
    }


    /**
     * List all tasks
     */
    #[Route('/tasks', name: 'task_list', methods: ['GET'])]
    public function listAction(): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->taskRepository->findAll()]);
    }



    /**
     * Create a new task
     */
    #[Route('/tasks/create', name: 'task_create', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUser($this->getUser());

            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }



    /**
     * Edit a task
     * @param int id
     */
    #[Route('/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function editAction(Task $task, Request $request): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }



    /**
     * Toggle a task status: done / undone
     * @param int id
     */
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task): Response
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }


    /**
     * Delete a task
     * @param int id
     */
    #[Route('/tasks/{id}/delete', name: 'task_delete', methods: ['GET', 'DELETE'])]
    public function deleteTaskAction(Task $task): Response
    {
        // Check if the logged-in user is the owner of the task
        if ( (!is_null($task->getUser()) && $this->getUser() !== $task->getUser()) ||
        // Check if the logged-in user has role admin to delete anonym task
            (is_null($task->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        )
        {
            $this->addFlash('error', "Vous n'avez pas l'autorisation de supprimer cette tâche.");
        }
        else
        {
            $this->entityManager->remove($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');

        }
        return $this->redirectToRoute('task_list');
    }
}
