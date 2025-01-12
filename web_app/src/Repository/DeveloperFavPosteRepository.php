<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\DeveloperFavPoste;
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

    //    /**
    //     * @return DeveloperFavPoste[] Returns an array of DeveloperFavPoste objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DeveloperFavPoste
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Ajoute ou retire un poste des favoris d'un développeur.
     *
     * @param Developer $developer
     * @param Poste $poste
     * @return string Message indiquant l'action effectuée
     */
    public function toggleFavoritePoste(Developer $developer, Poste $poste): void
    {
        // Vérifie si la relation existe déjà
        $exists = $this->createQueryBuilder('dfp')
            ->andWhere('dfp.developer = :developer')
            ->andWhere('dfp.poste = :poste')
            ->setParameter('developer', $developer)
            ->setParameter('poste', $poste)
            ->getQuery()
            ->getOneOrNullResult();

        if ($exists) {
            // Si la relation existe déjà, la retirer
            $this->_em->remove($exists);
            $this->_em->flush();

            return;
        }

        // Sinon, ajouter le poste en favoris
        $favorite = new DeveloperFavPoste();
        $favorite->setDeveloper($developer);
        $favorite->setPoste($poste);
        // $favorite->setAddedAt(new \DateTime());

        $this->_em->persist($favorite);
        $this->_em->flush();

        return;
    }

    /**
     * Récupère tous les postes favoris d'un développeur.
     *
     * @param Developer $developer
     * @return array Liste des postes favoris
     */
    public function findFavoritePostesByDeveloper(Developer $developer): array
    {
        return $this->createQueryBuilder('dfp')
            ->join('dfp.poste', 'p') // Jointure avec la table "Poste"
            ->addSelect('p') // Inclut les données du poste
            ->andWhere('dfp.developer = :developer')
            ->setParameter('developer', $developer)
            ->orderBy('dfp.addedAt', 'DESC') // Trie par date d'ajout (optionnel)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les postes les plus ajoutés en favoris.
     *
     * @return array Liste des postes les plus populaires avec leur nombre de favoris
     */
    public function findTopMostFavoritedPostes(int $limite): array
    {
        return $this->createQueryBuilder('dfp')
            ->select('p as poste, COUNT(dfp.id) as favoriteCount')
            ->join('dfp.poste', 'p')
            ->groupBy('p.id')
            ->orderBy('favoriteCount', 'DESC')
            ->setMaxResults($limite)
            ->getQuery()
            ->getResult();
    }


}
