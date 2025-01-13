<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyFavDeveloper;
use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyFavDeveloper>
 */
class CompanyFavDeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyFavDeveloper::class);
    }

    //    /**
    //     * @return CompanyFavDeveloper[] Returns an array of CompanyFavDeveloper objects
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

    //    public function findOneBySomeField($value): ?CompanyFavDeveloper
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Enregistre ou supprime un développeur comme favori d'une entreprise
     *
     * @param Company $company
     * @param Developer $developer
     * @return void
     */
    public function addOrRemoveFavoriteDeveloper(Company $company, Developer $developer): void
    {
        // Vérifie si la relation existe déjà
        // $exists = $this->createQueryBuilder('chd')
        //     ->andWhere('chd.company = :company')
        //     ->andWhere('chd.developer = :developer')
        //     ->setParameter('company', $company)
        //     ->setParameter('developer', $developer)
        //     ->getQuery()
        //     ->getOneOrNullResult();
        $sql = "SELECT COUNT(*) FROM company_has_developer WHERE developer_id = :developerId AND company_id = :companyId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['developerId' => $developer->getId(), 'companyId' => $company->getId()]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            // Si la relation existe déjà, retirer des favoris
            $this->_em->remove($exists);
            $this->_em->flush();

            return;
        }

        // Crée une nouvelle instance de CompanyHasDeveloper
        $favorite = new CompanyFavDeveloper();
        $favorite->setCompany($company);
        $favorite->setDeveloper($developer);
        // $favorite->setAddedAt(new \DateTime());

        $this->_em->persist($favorite);
        $this->_em->flush();
    }

    
    /**
     * Récupère tous les développeurs favoris d'une entreprise
     *
     * @param Company $company
     * @return array Liste des développeurs favoris
     */
    public function findFavoriteDevelopersByCompany(Company $company): array
    {
        // return $this->createQueryBuilder('chd')
        //     ->join('chd.developer', 'd')
        //     ->addSelect('d') // Inclut les données du développeur
        //     ->andWhere('chd.company = :company')
        //     ->setParameter('company', $company)
        //     ->orderBy('chd.id', 'DESC')
        //     ->getQuery()
        //     ->getResult();
        $sql = "SELECT d.* FROM developer d
            JOIN company_has_developer cd ON d.id = cd.developer_id
            WHERE cd.company_id = :companyId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['companyId' => $company->getId()]);
        
        $results = $stmt->fetchAll();
        return $results;
    }
}
