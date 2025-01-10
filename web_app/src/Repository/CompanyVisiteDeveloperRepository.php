<?php

namespace App\Repository;

use App\Entity\CompanyVisiteDeveloper;
use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyVisiteDeveloper>
 */
class CompanyVisiteDeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyVisiteDeveloper::class);
    }

    //    /**
    //     * @return CompanyVisiteDeveloper[] Returns an array of CompanyVisiteDeveloper objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompanyVisiteDeveloper
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function addView(CompanyVisiteDeveloper $view ,Developer $dev): void
    {
        $view = new CompanyVisiteDeveloper($view);
        $dev = new Developer($dev);
        $this->_em->persist($view,$dev);
        $this->_em->flush();
    }
    public function countViews(CompanyVisiteDeveloper $view): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.dev = :dev')
            ->setParameter('dev', $view)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
