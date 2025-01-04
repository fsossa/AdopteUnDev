<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Developer;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

use function Symfony\Component\Clock\now;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    // public static function createDefaultUser(EntityManager $entityM, bool $isDev){
    //     $user = new User();
    //     $user->setEmail('developer@test.xyz');
    //     $user->setRoles(['ROLE_DEV']);
    //     $user->setPassword(password_hash('123456', PASSWORD_BCRYPT));
    //     $user->setVerified(true);
    //     $user->setCreatedAt(now());
    //     $user->setUpdatedAt(now());
        
    //     $entityM->persist($user);
    //     $entityM->flush();

    //     if ($isDev) UserRepository::createDefaultDev($entityM, $user);
    //     else UserRepository::createDefaultCompany($entityM, $user);

    // }

    // public function createDefaultDev(EntityManager $entityM, User $user){
    //     $dev = new Developer();
    //     $dev->setFirstname('Ange');
    //     $dev->setLastname('GOHI');
    //     // $dev->setBirthday(now());
    //     $dev->setExperiences(2);
    //     $dev->setSalary(2000);
    //     $dev->setUser($user);
        
    //     $entityM->persist($dev);
    //     $entityM->flush();
    // }

    // public function createDefaultCompany(EntityManager $entityM, User $user){
    //     $company = new Company();
    //     $company->setUser($user);
    //     $company->setName('CICASYS');
        
    //     $entityM->persist($company);
    //     $entityM->flush();
    // }
}
