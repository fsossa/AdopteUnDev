<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Poste;
use App\Repository\DeveloperFavPosteRepository;
use App\Repository\DeveloperRepository;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavouritePosteController extends AbstractController
{
    /**
     * Liste les postes favoris d'un développeur.
     *
     * @Route("/favourites/{developerId}", name="favourite_list")
     */
    public function listFavourites(
        int $developerId,
        DeveloperFavPosteRepository $repository,
        DeveloperRepository $developerRepository,
        PosteRepository $posteRepository
    ): Response {
        // Récupérer le développeur
        $developer = $developerRepository->find($developerId);

        if (!$developer) {
            throw $this->createNotFoundException('Développeur non trouvé.');
        }

        // Récupérer les postes favoris
        $favourites = $repository->findFavoritesByDeveloper($developer);

        // Récupérer tous les postes correspondants (optionnel, si nécessaire)
        // $allPostes = $posteRepository->matchPostes($developer);

        return $this->render('favourite/list.html.twig', [
            'developer' => $developer,
            'favourites' => $favourites,
            // 'allPostes' => $allPostes, // Si nécessaire
        ]);
    }

    /**
     * Ajoute un poste aux favoris d'un développeur.
     *
     * @Route("/favourite/add/{developerId}/{posteId}", name="favourite_add", methods={"POST"})
     */
    public function addFavourite(
        int $developerId,
        int $posteId,
        DeveloperFavPosteRepository $repository,
        DeveloperRepository $developerRepository,
        PosteRepository $posteRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer le développeur et le poste
        $developer = $developerRepository->find($developerId);
        $poste = $posteRepository->find($posteId);

        if (!$developer || !$poste) {
            throw $this->createNotFoundException('Développeur ou poste non trouvé.');
        }

        // Vérifier si le poste est déjà dans les favoris
        $existingFav = $repository->findOneBy([
            'developer' => $developer,
            'poste' => $poste,
        ]);

        if ($existingFav) {
            $this->addFlash('warning', 'Le poste est déjà dans vos favoris.');
        } else {
            // Ajouter le favori
            $favourite = new DeveloperFavPoste();
            $favourite->setDeveloper($developer);
            $favourite->setPoste($poste);
            $entityManager->persist($favourite);
            $entityManager->flush();

            $this->addFlash('success', 'Poste ajouté à vos favoris.');
        }

        return $this->redirectToRoute('match_postes', ['developerId' => $developerId]);
    }

    /**
     * Supprime un poste des favoris d'un développeur.
     *
     * @Route("/favourite/remove/{developerId}/{posteId}", name="favourite_remove", methods={"POST"})
     */
    public function removeFavourite(
        int $developerId,
        int $posteId,
        DeveloperFavPosteRepository $repository,
        DeveloperRepository $developerRepository,
        PosteRepository $posteRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer le développeur et le poste
        $developer = $developerRepository->find($developerId);
        $poste = $posteRepository->find($posteId);

        if (!$developer || !$poste) {
            throw $this->createNotFoundException('Développeur ou poste non trouvé.');
        }

        // Trouver le favori à supprimer
        $favourite = $repository->findOneBy([
            'developer' => $developer,
            'poste' => $poste,
        ]);

        if ($favourite) {
            $entityManager->remove($favourite);
            $entityManager->flush();

            $this->addFlash('success', 'Poste supprimé de vos favoris.');
        } else {
            $this->addFlash('warning', 'Ce poste n\'est pas dans vos favoris.');
        }

        return $this->redirectToRoute('match_postes', ['developerId' => $developerId]);
    }
}
