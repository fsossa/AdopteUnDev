<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Form\DeveloperType;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/developer/'), ]
final class DeveloperController extends AbstractController
{
    #[Route(name: 'app_developer_home', methods: ['GET'])]
    public function index(DeveloperRepository $developerRepository): Response
    {
        return $this->render('developers/profile.html.twig', [
            'developers' => $developerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_developer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/new.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_developer_show', methods: ['GET'])]
    public function show(Developer $developer): Response
    {
        return $this->render('developer/show.html.twig', [
            'developer' => $developer,
        ]);
    }

    #[Route('/{id}', name: 'app_developer_profile', methods: ['GET'])]
    public function profile(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/profile.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_developer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/profile.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_developer_delete', methods: ['POST'])]
    public function delete(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$developer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($developer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_developer_index', [], Response::HTTP_SEE_OTHER);
    }
}