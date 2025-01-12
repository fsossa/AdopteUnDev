<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyVisiteDeveloper;
use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyVisiteDeveloper>
 */
class CompanyVisiteDeveloperRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, CompanyVisiteDeveloper::class);
        $this->entityManager = $entityManager;
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
    public function recordVisit(Company $company, Developer $developer): void
    {
        // Vérifie si la relation existe déjà
        // $exists = $this->createQueryBuilder('chd')
        //     ->andWhere('chd.company = :company')
        //     ->andWhere('chd.developer = :developer')
        //     ->setParameter('company', $company)
        //     ->setParameter('developer', $developer)
        //     ->getQuery()
        //     ->getOneOrNullResult();
        
        // $pdo = $this->getDoctrine()->getManager()->getConnection();
        $sql = "SELECT COUNT(*) FROM company_visite_developer WHERE company_id = :companyId AND developer_id = :developerId";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql, ['developerId' => $developer->getId(), 'companyId' => $company->getId()]);
        $exists = $results->fetchAllAssociative();

        if ($exists) {
            // Si la relation existe déjà, ne rien faire
            return;
        }

        $visit = new CompanyVisiteDeveloper();
        $visit->setCompany($company);
        $visit->setDeveloper($developer);
        // $visit->setVisitedAt(new \DateTime()); 

        $this->_em->persist($visit);
        $this->_em->flush();
    }

    /**
     * Récupère toutes les visites d'un développeur
     */
    public function findVisitsForDeveloper(Developer $developer, int $limite): array
    {
        // return $this->createQueryBuilder('cvd')
        //     ->andWhere('cvd.developer = :developer')
        //     ->setParameter('developer', $developer)
        //     ->orderBy('cvd.id', 'DESC') // Trier par date de visite, optionnel
        //     ->getQuery()
        //     ->getResult();
        
        // Sélectionner les visites pour un développeur
        $sql = "SELECT c.* FROM company_visite_developer v 
                JOIN company c ON v.company_id = c.id 
                WHERE v.developer_id = :developerId
                LIMIT $limite";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql, ['developerId' => $developer->getId()]);
        return $results->fetchAllAssociative();
    }

    /**
     * Récupère les développeurs les plus visités
     */
    public function findTopMostVisitedDevelopers(int $limite): array
    {
        // return $this->createQueryBuilder('cvd')
        //     ->select('d, COUNT(cvd.id) AS visit_count')
        //     ->join('cvd.developer', 'd')
        //     ->groupBy('d.id')
        //     ->orderBy('visit_count', 'DESC')
        //     ->setMaxResults($limite)
        //     ->getQuery()
        //     ->getResult();
        // Sélectionner les développeurs les plus visités
        $sql = "SELECT d.*, COUNT(v.id) AS visit_count FROM developer d
            LEFT JOIN company_visite_developer v ON v.developer_id = d.id
            GROUP BY d.id
            ORDER BY visit_count DESC
            LIMIT :limite";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql, ['limite' => $limite]);
        return $results->fetchAllAssociative();
    }

    public function findLastDevelopers(int $limite): array
    {
        // return $this->createQueryBuilder('cvd')
        //     ->select('d, COUNT(cvd.id) AS visit_count')
        //     ->join('cvd.developer', 'd')
        //     ->groupBy('d.id')
        //     ->orderBy('d.id', 'DESC')
        //     ->setMaxResults($limite)
        //     ->getQuery()
        //     ->getResult();
        $sql = "SELECT * FROM developer ORDER BY id DESC 
                LIMIT :limite";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql, ['limite' => $limite]);
        return $results->fetchAllAssociative();
    }
    // public function addView(CompanyVisiteDeveloper $view ,Developer $dev): void
    // {
    //     $view = new CompanyVisiteDeveloper($view);
    //     $dev = new Developer($dev);
    //     $this->_em->persist($view,$dev);
    //     $this->_em->flush();
    // }
    // public function countViews(CompanyVisiteDeveloper $view): int
    // {
    //     return $this->createQueryBuilder('v')
    //         ->select('COUNT(v.id)')
    //         ->where('v.dev = :dev')
    //         ->setParameter('dev', $view)
    //         ->getQuery()
    //         ->getSingleScalarResult();
    // }
}
