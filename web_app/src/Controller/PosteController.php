<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/postes')]
final class PosteController extends AbstractController
{
    #[Route(name: 'app_poste_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }

    #[Route('/match', name: 'app_poste_match', methods: ['GET'])]
    public function match(PosteRepository $posteRepository): Response
    {
        $authUser = $this->getUser();
        $postes = $posteRepository->matchPostes($authUser);
        // if ($this->isGranted('ROLE_DEV')) {
        //     $postes = $posteRepository->matchPostes($authUser);
        // }
        // if ($this->isGranted('ROLE_COMPANY')) {
        //     $postes = $posteRepository->matchDev();
        // }
        return $this->render('poste/index.html.twig', [
            'postes' => $postes,
        ]);
    }

    #[Route('/new', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($poste);
            $entityManager->flush();

            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_show', methods: ['GET'])]
    public function show(Poste $poste): Response
    {
        return $this->render('poste/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_poste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Poste $poste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_delete', methods: ['POST'])]
    public function delete(Request $request, Poste $poste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($poste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
    }
}
