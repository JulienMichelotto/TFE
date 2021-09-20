<?php

namespace App\Repository;

use App\Entity\UserImg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserImg|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserImg|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserImg[]    findAll()
 * @method UserImg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserImgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserImg::class);
    }

    // /**
    //  * @return UserImg[] Returns an array of UserImg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserImg
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
