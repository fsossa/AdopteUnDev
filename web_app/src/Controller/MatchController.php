<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Repository\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match/{developerId}', name: 'match_postes')]
    public function matchPostes(int $developerId, DeveloperRepository $developerRepository, PosteRepository $posteRepository): Response
    {
        // Récupérer le développeur
        $developer = $developerRepository->find($developerId);

        if (!$developer) {
            throw $this->createNotFoundException('Développeur non trouvé.');
        }

        // Récupérer les postes correspondants
        $matches = $posteRepository->matchPostes($developer);

        return $this->render('match/list.html.twig', [
            'developer' => $developer,
            'matches' => $matches,
        ]);
    }
}
