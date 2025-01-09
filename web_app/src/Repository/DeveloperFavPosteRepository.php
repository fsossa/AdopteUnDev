<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\DeveloperFavPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeveloperFavPoste>
 *
 * @method DeveloperFavPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeveloperFavPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeveloperFavPoste[]    findAll()
 * @method DeveloperFavPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperFavPosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperFavPoste::class);
    }

    /**
     * Trouve les postes favoris pour un développeur donné.
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
}
