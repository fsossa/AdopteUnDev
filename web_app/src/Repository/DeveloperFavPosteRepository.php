<?php

namespace App\Repository;

use App\Entity\DeveloperFavPoste;
use App\Entity\Developer;
use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeveloperFavPoste>
 */
class DeveloperFavPosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperFavPoste::class);
    }

    /**
     * Ajoute un favori pour un développeur.
     *
     * @param Developer $developer
     * @param Poste $poste
     */
    public function addFavorite(Developer $developer, Poste $poste): void
    {
        $entityManager = $this->getEntityManager();

        $developerFavPoste = new DeveloperFavPoste();
        $developerFavPoste->setDeveloper($developer);
        $developerFavPoste->setPoste($poste);

        $entityManager->persist($developerFavPoste);
        $entityManager->flush();
    }

    /**
     * Liste les favoris de postes pour un développeur.
     *
     * @param Developer $developer
     * @return DeveloperFavPoste[]
     */
    public function findFavoritesByDeveloper(Developer $developer): array
    {
        return $this->createQueryBuilder('dfp')
            ->andWhere('dfp.developer = :developer')
            ->setParameter('developer', $developer)
            ->getQuery()
            ->getResult();
    }

    /**
     * Supprime un favori de poste pour un développeur.
     *
     * @param Developer $developer
     * @param Poste $poste
     */
    public function removeFavorite(Developer $developer, Poste $poste): void
    {
        $entityManager = $this->getEntityManager();

        $developerFavPoste = $this->createQueryBuilder('dfp')
            ->andWhere('dfp.developer = :developer')
            ->andWhere('dfp.poste = :poste')
            ->setParameter('developer', $developer)
            ->setParameter('poste', $poste)
            ->getQuery()
            ->getOneOrNullResult();

        if ($developerFavPoste) {
            $entityManager->remove($developerFavPoste);
            $entityManager->flush();
        }
    }
}
