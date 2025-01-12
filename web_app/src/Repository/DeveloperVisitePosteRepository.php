<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\DeveloperVisitePoste;
use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeveloperVisitePoste>
 */
class DeveloperVisitePosteRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, DeveloperVisitePoste::class);
        $this->entityManager = $entityManager;
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

    /**
     * Enregistre une visite d'un poste par un développeur
     *
     * @param Developer $developer
     * @param Post $post
     * @return void
     */
    public function addPostVisit(Developer $developer, Poste $poste): void
    {
        $conn = $this->getEntityManager()->getConnection();
        // Vérifie si la visite existe déjà pour éviter les doublons
        // $exists = $this->createQueryBuilder('dvp')
        //     ->andWhere('dvp.developer = :developer')
        //     ->andWhere('dvp.post = :post')
        //     ->setParameter('developer', $developer)
        //     ->setParameter('post', $poste)
        //     ->getQuery()
        //     ->getOneOrNullResult();
        // Vérifier si la visite existe déjà

        $sql = "SELECT COUNT(*) FROM developer_visite_poste WHERE developer_id = :developerId AND poste_id = :posteId";
        // $pdo = $this->entityManager->getConnection();
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(['developerId' => $developer->getId(), 'posteId' => $poste->getId()]);
        // $exists = $stmt->fetchColumn();
        $exists = $conn->executeQuery($sql, ['developerId' => $developer->getId(), 'posteId' => $poste->getId()]);

        if ($exists->fetchAllAssociative()) {
            // Si la visite existe déjà, ne rien faire
            return;
        }

        // Crée une nouvelle instance DeveloperVisitedPost
        $visit = new DeveloperVisitePoste();
        $visit->setDeveloper($developer);
        $visit->setPoste($poste);
        // $visit->setVisitedAt(new \DateTime()); 

        $this->_em->persist($visit);
        $this->_em->flush();
    }

    /**
     * Récupère toutes les visites d'un poste
     *
     * @param Post $post
     * @return array Liste des développeurs ayant visité ce poste
     */
    public function findAllVisitsByPoste(Poste $poste): array
    {
        // return $this->createQueryBuilder('dvp')
        //     ->join('dvp.developer', 'd')
        //     ->addSelect('d') // Inclut les données du développeur
        //     ->andWhere('dvp.poste = :poste')
        //     ->setParameter('poste', $poste)
        //     ->orderBy('dvp.visitedAt', 'DESC') // Trie par date de visite, optionnel
        //     ->getQuery()
        //     ->getResult();
        $sql = "SELECT d.* FROM developer_visite_poste v
                JOIN developer d ON v.developer_id = d.id
                WHERE v.poste_id = :posteId
                ORDER BY d.id DESC";
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql, ['posteId' => $poste->getId()]);
        return $results->fetchAllAssociative();
    }

    /**
     * Récupère les postes les plus visités
     *
     * @return array Liste des postes les plus visités avec leur nombre de visites
     */
    public function findTopMostVisitedPostes(int $limite): array
    {
        // return $this->createQueryBuilder('dvp')
        //     ->select('p as poste, COUNT(dvp.id) as visitCount')
        //     ->join('dvp.poste', 'p')
        //     ->groupBy('p.id')
        //     ->orderBy('visitCount', 'DESC')
        //     ->setMaxResults($limite)
        //     ->getQuery()
        //     ->getResult();
        $sql = "SELECT p.*, COUNT(v.id) AS visit_count FROM poste p
            LEFT JOIN developer_visite_poste v ON v.poste_id = p.id
            GROUP BY p.id
            ORDER BY visit_count DESC
            LIMIT $limite";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql);
        return $results->fetchAllAssociative();
    }

    public function findLastPostes(int $limite): array
    {
        $entityManager = $this->getEntityManager();
        // return $this->createQueryBuilder('dvp')
        //     ->select('p as poste, COUNT(dvp.id) as visitCount')
        //     ->join('dvp.poste', 'p')
        //     ->groupBy('p.id')
        //     ->orderBy('p.id', 'DESC')
        //     ->setMaxResults($limite)
        //     ->getQuery()
        //     ->getResult();
        $sql = "SELECT p.*, COUNT(v.id) AS visit_count FROM poste p
            LEFT JOIN developer_visite_poste v ON v.poste_id = p.id
            GROUP BY p.id
            ORDER BY p.id DESC    
            LIMIT $limite";
        
        $conn = $this->getEntityManager()->getConnection();
        $results = $conn->executeQuery($sql);
        return $results->fetchAllAssociative();
    }

    // public function addView(DeveloperVisitePoste $view ,Poste $post): void
    // {
    //     $view = new DeveloperVisitePoste($view);
    //     $post = new Poste($post);
    //     $this->_em->persist($view,$post);
    //     $this->_em->flush();
    // }
    // public function countViews(DeveloperVisitePoste $view): int
    // {
    //     return $this->createQueryBuilder('v')
    //         ->select('COUNT(v.id)')
    //         ->where('v.post = :post')
    //         ->setParameter('post', $view)
    //         ->getQuery()
    //         ->getSingleScalarResult();
    // }


}
