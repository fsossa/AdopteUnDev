<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/skill')]
class SkillController extends AbstractController
{
    // Liste des compétences les plus populaires
    #[Route('/popular', name: 'app_skill_popular', methods: ['GET'])]
    public function popular(SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->findMostPopularSkills();
        return $this->render('skill/popular.html.twig', [
            'skills' => $skills,
        ]);
    }

    // Recherche de compétences par mot-clé
    #[Route('/search', name: 'app_skill_search', methods: ['GET'])]
    public function search(Request $request, SkillRepository $skillRepository): Response
    {
        $keyword = $request->query->get('keyword', '');
        $skills = $skillRepository->searchByKeyword($keyword);

        return $this->render('skill/search.html.twig', [
            'skills' => $skills,
            'keyword' => $keyword,
        ]);
    }

    // Récupérer les compétences d'un développeur spécifique
    #[Route('/developer/{developerId}', name: 'app_skill_by_developer', methods: ['GET'])]
    public function skillsByDeveloper(int $developerId, SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->findSkillsByDeveloper($developerId);

        return $this->render('skill/developer_skills.html.twig', [
            'skills' => $skills,
        ]);
    }
}
