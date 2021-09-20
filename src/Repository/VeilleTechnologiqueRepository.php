<?php

namespace App\Repository;

use App\Entity\VeilleTechnologique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VeilleTechnologique|null find($id, $lockMode = null, $lockVersion = null)
 * @method VeilleTechnologique|null findOneBy(array $criteria, array $orderBy = null)
 * @method VeilleTechnologique[]    findAll()
 * @method VeilleTechnologique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VeilleTechnologiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VeilleTechnologique::class);
    }

    // /**
    //  * @return VeilleTechnologique[] Returns an array of VeilleTechnologique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VeilleTechnologique
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
