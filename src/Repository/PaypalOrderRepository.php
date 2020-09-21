<?php

namespace App\Repository;

use App\Entity\PaypalOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaypalOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaypalOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaypalOrder[]    findAll()
 * @method PaypalOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaypalOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaypalOrder::class);
    }

    // /**
    //  * @return PaypalOrder[] Returns an array of PaypalOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaypalOrder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
