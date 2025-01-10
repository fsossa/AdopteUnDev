<?php

namespace App\Repository;
use App\Entity\DeveloperVisitePoste;
use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeveloperVisitePoste>
 */
class DeveloperVisitePosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperVisitePoste::class);
    }

    //    /**
    //     * @return DeveloperVisitePoste[] Returns an array of DeveloperVisitePoste objects
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

    //    public function findOneBySomeField($value): ?DeveloperVisitePoste
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function addView(DeveloperVisitePoste $view ,Poste $post): void
    {
        $view = new DeveloperVisitePoste($view);
        $post = new Poste($post);
        $this->_em->persist($view,$post);
        $this->_em->flush();
    }
    public function countViews(DeveloperVisitePoste $view): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.post = :post')
            ->setParameter('post', $view)
            ->getQuery()
            ->getSingleScalarResult();
    }


}
