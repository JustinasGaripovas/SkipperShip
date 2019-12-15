<?php

namespace App\Repository;

use App\Entity\WarehouseWorker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WarehouseWorker|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseWorker|null findOneBy(array $criteria, array $orderBy = null)
 * @method WarehouseWorker[]    findAll()
 * @method WarehouseWorker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarehouseWorkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseWorker::class);
    }

    // /**
    //  * @return WarehouseWorker[] Returns an array of WarehouseWorker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WarehouseWorker
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
