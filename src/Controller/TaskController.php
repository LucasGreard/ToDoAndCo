<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/task")
 * @IsGranted("ROLE_USER")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_index", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->getRoles() == ["ROLE_ADMIN"])
                return $this->render('task/index.html.twig', [
                    'tasks' => $taskRepository->findAll(),
                ]);
            return $this->render('task/index.html.twig', [
                'tasks' => $taskRepository->findTaskByUser($this->getUser()->getId()),
            ]);
        }
    }

    /**
     * @Route("/new", name="task_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $task->setCreatedAt(new DateTimeImmutable('now'));
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_index', [], 201);
        }

        return $this->renderForm('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        if ($task->getUser()->getEmail() == $this->getUser()->getUserIdentifier() || $this->getUser()->getRoles() == ['ROLE_ADMIN']) {
            return $this->render('task/show.html.twig', [
                'task' => $task,
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($task->getUser()->getEmail() == $this->getUser()->getUserIdentifier() || $this->getUser()->getRoles() == ['ROLE_ADMIN']) {
            $form = $this->createForm(TaskType::class, $task);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('task_index', [], 200);
            }

            return $this->renderForm('task/edit.html.twig', [
                'task' => $task,
                'form' => $form,
            ]);
        }
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"POST"})
     */
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_index', [], Response::HTTP_SEE_OTHER);
    }
}
