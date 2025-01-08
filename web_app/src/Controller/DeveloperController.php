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

#[Route('/app/developer/')]
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

        return $this->render('developers/new.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_developer_show', methods: ['GET'])]
    public function show(Developer $developer): Response
    {
        return $this->render('developers/show.html.twig', [
            'developer' => $developer,
        ]);
    }

    #[Route('/profile/{id}', name: 'app_developer_profile', methods: ['GET'])]
    public function profile(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developers/profile.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_developer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developers/profile.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_developer_delete', methods: ['POST'])]
    public function delete(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $developer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($developer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_developer_index', [], Response::HTTP_SEE_OTHER);
    }

    // ===================== Routes Métiers =====================

    // Liste des développeurs triée par expérience
    #[Route('/api/list', name: 'developers_list', methods: ['GET'])]
    public function list(DeveloperRepository $developerRepository): Response
    {
        $developers = $developerRepository->findAllOrderedByExperience();
        return $this->json($developers);
    }

    // Recherche par mot-clé
    #[Route('/api/search', name: 'developers_search', methods: ['GET'])]
    public function search(Request $request, DeveloperRepository $developerRepository): Response
    {
        $keyword = $request->query->get('keyword', '');
        $developers = $developerRepository->searchByKeyword($keyword);
        return $this->json($developers);
    }

    // Filtrage par compétence
    #[Route('/api/skill/{skill}', name: 'developers_by_skill', methods: ['GET'])]
    public function bySkill(string $skill, DeveloperRepository $developerRepository): Response
    {
        $developers = $developerRepository->findBySkill($skill);
        return $this->json($developers);
    }

    // Filtrage par salaire minimum
    #[Route('/api/salary/{minSalary}', name: 'developers_by_salary', methods: ['GET'])]
    public function bySalary(int $minSalary, DeveloperRepository $developerRepository): Response
    {
        $developers = $developerRepository->findByMinSalary($minSalary);
        return $this->json($developers);
    }

    // Filtrage par expérience
    #[Route('/api/experience/{minExperience}', name: 'developers_by_experience', methods: ['GET'])]
    public function byExperience(int $minExperience, DeveloperRepository $developerRepository): Response
    {
        $developers = $developerRepository->findByExperienceGreaterThan($minExperience);
        return $this->json($developers);
    }

    // Pagination des développeurs
    #[Route('/api/paginated', name: 'developers_paginated', methods: ['GET'])]
    public function paginated(Request $request, DeveloperRepository $developerRepository): Response
    {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 10);
        $developers = $developerRepository->findPaginated($page, $limit);
        return $this->json($developers);
    }

    // Nombre total de développeurs
    #[Route('/api/count', name: 'developers_count', methods: ['GET'])]
    public function count(DeveloperRepository $developerRepository): Response
    {
        $count = $developerRepository->countAll();
        return $this->json(['count' => $count]);
    }
}
