<?php

namespace App\Repository;

use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Developer>
 */
class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    /**
     * Récupère tous les développeurs triés par expérience.
     *
     * @param string $order ASC ou DESC
     * @return Developer[]
     */
    public function findAllOrderedByExperience(string $order = 'DESC'): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.experiences', $order)
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les développeurs par un mot-clé dans le prénom, le nom ou la biographie.
     *
     * @param string $keyword
     * @return Developer[]
     */
    public function searchByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.firstname LIKE :keyword')
            ->orWhere('d.lastname LIKE :keyword')
            ->orWhere('d.biography LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les développeurs avec un salaire supérieur à un montant donné.
     *
     * @param int $minSalary
     * @return Developer[]
     */
    public function findByMinSalary(int $minSalary): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.salary >= :minSalary')
            ->setParameter('minSalary', $minSalary)
            ->orderBy('d.salary', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les développeurs ayant une compétence spécifique.
     *
     * @param string $skillName
     * @return Developer[]
     */
    public function findBySkill(string $skillName): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.skills', 's')
            ->where('s.name = :skillName')
            ->setParameter('skillName', $skillName)
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les développeurs ayant plus de X années d'expérience.
     *
     * @param int $minExperience
     * @return Developer[]
     */
    public function findByExperienceGreaterThan(int $minExperience): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.experiences > :minExperience')
            ->setParameter('minExperience', $minExperience)
            ->orderBy('d.experiences', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère une liste paginée des développeurs.
     *
     * @param int $page
     * @param int $limit
     * @return Developer[]
     */
    public function findPaginated(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder('d')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Compte le nombre total de développeurs.
     *
     * @return int
     */
    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
