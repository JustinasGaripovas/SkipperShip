<?php

namespace App\Repository;

use App\Entity\Delivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Delivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivery[]    findAll()
 * @method Delivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    /**
      * @return Delivery[] Returns an array of Delivery objects
      */
    public function findAllUnassignedDeliveries()
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.warehouse IS NULL')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Delivery
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
