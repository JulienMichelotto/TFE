<?php

namespace App\Repository;

use App\Entity\ExtraDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExtraDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtraDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtraDetail[]    findAll()
 * @method ExtraDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtraDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtraDetail::class);
    }

    // /**
    //  * @return ExtraDetail[] Returns an array of ExtraDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExtraDetail
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
