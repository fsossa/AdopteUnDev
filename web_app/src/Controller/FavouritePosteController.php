<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\DeveloperFavPoste;
use App\Entity\Poste;
use App\Repository\DeveloperFavPosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavouritePosteController extends AbstractController
{
     // Route pour lister les favoris
    /**
     * @Route("/favourites/{developerId}", name="favourite_list")
     */
    public function listFavourites(int $developerId, DeveloperFavPosteRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($developerId);

        if (!$developer) {
            throw $this->createNotFoundException('Développeur non trouvé.');
        }

        // Récupérer les favoris du développeur
        $favourites = $repository->findFavoritesByDeveloper($developer);

        // Récupérer tous les postes disponibles pour l'ajout
        $allPostes = $entityManager->getRepository(Poste::class)->findAll();

        return $this->render('favourite/list.html.twig', [
            'developer' => $developer,
            'favourites' => $favourites,
            'allPostes' => $allPostes
        ]);
    }

    // Route pour ajouter un favori
    /**
     * @Route("/favourites/{developerId}/add", name="favourite_add", methods={"POST"})
     */
    public function addFavorite(int $developerId, Request $request, DeveloperFavPosteRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($developerId);

        if (!$developer) {
            throw $this->createNotFoundException('Développeur non trouvé.');
        }

        $posteId = $request->request->get('poste');
        $poste = $entityManager->getRepository(Poste::class)->find($posteId);

        if (!$poste) {
            throw $this->createNotFoundException('Poste non trouvé.');
        }

        // Ajouter le poste aux favoris
        $favourite = new DeveloperFavPoste();
        $favourite->setDeveloper($developer);
        $favourite->setPoste($poste);
        $entityManager->persist($favourite);
        $entityManager->flush();

        return $this->redirectToRoute('favourite_list', ['developerId' => $developerId]);
    }

    // Route pour supprimer un favori
    /**
     * @Route("/favourites/{developerId}/remove/{posteId}", name="favourite_remove")
     */
    public function removeFavorite(int $developerId, int $posteId, DeveloperFavPosteRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($developerId);

        if (!$developer) {
            throw $this->createNotFoundException('Développeur non trouvé.');
        }

        $favourite = $repository->findOneBy([
            'developer' => $developer,
            'poste' => $posteId
        ]);

        if ($favourite) {
            $entityManager->remove($favourite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favourite_list', ['developerId' => $developerId]);
    }
}
