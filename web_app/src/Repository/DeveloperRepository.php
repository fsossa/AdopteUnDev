<?php

namespace App\Repository;

use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Developer>
 */
class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    //    /**
    //     * @return Developer[] Returns an array of Developer objects
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

    //    public function findOneBySomeField($value): ?Developer
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findLatestVisiteAndLike(int $limite): array 
    {
        return $this->createQueryBuilder('d')
        ->orderBy('d.id', 'DESC')
        ->setMaxResults($limite)
        ->getQuery()
        ->getResult();

    }
    public function findBest(int $limite): array
{
    return $this->createQueryBuilder('poste')
        ->select('dev, COUNT(companyVisitDev.id) AS viewCount') 
        ->join('companyVisitDev.developer', 'dev') 
        ->groupBy('dev.id') 
        ->orderBy('viewCount', 'DESC') 
        ->setMaxResults($limite) 
        ->getQuery()
        ->getResult();
}
  
}
