<?php

namespace App\Repository;

use App\Entity\CustomFieldValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomFieldValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomFieldValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomFieldValue[]    findAll()
 * @method CustomFieldValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomFieldValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomFieldValue::class);
    }

    // /**
    //  * @return CustomFieldValue[] Returns an array of CustomFieldValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomFieldValue
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
