<?php

namespace App\Repository;

use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Developer;

/**
 * @extends ServiceEntityRepository<Poste>
 */
class PosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poste::class);
    }

     /**
     * Recherche des postes correspondant aux compétences d'un développeur.
     * Retourne une liste triée par nombre de compétences correspondantes.
     *
     * @param Developer $developer
     * @return array
     */
    public function matchPostes(Developer $developer): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p, COUNT(s.id) AS skill_count')
            ->join('p.skills', 's')
            ->where('s IN (:skills)')
            ->setParameter('skills', $developer->getSkills())
            ->groupBy('p.id')
            ->orderBy('skill_count', 'DESC');

        $results = $qb->getQuery()->getResult();

        $matches = [];
        foreach ($results as $result) {
            /** @var Poste $poste */
            $poste = $result[0];
            $skillCount = $result['skill_count'];
            $totalSkills = count($poste->getSkills());
            $percentage = $totalSkills > 0 ? ($skillCount / $totalSkills) * 100 : 0;
            $matches[] = [
                'poste' => $poste,
                'skill_count' => $skillCount,
                'total_skills' => $totalSkills,
                'percentage' => $percentage,
            ];
        }

        return $matches;
    }

    //    /**
    //     * @return Poste[] Returns an array of Poste objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Poste
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    public function findBest(int $limite): array {
        
        return [];
    }
    
    public function findLatest(int $limite): array {
        
        return [];
    }
}
