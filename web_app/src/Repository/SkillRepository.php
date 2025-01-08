<?php
namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    // Rechercher des compétences par mot-clé (nom de la compétence)
    public function searchByKeyword(string $keyword)
    {
        return $this->createQueryBuilder('s')
            ->where('s.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

    // Récupérer les compétences les plus populaires (en fonction du nombre de développeurs associés)
    public function findMostPopularSkills()
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.developers', 'd')
            ->groupBy('s.id')
            ->orderBy('COUNT(d.id)', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // Récupérer toutes les compétences d'un développeur spécifique
    public function findSkillsByDeveloper(int $developerId)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.developers', 'd')
            ->where('d.id = :developerId')
            ->setParameter('developerId', $developerId)
            ->getQuery()
            ->getResult();
    }
}
