<?php

namespace App\Repository;

use App\Entity\AnimalAccessory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnimalAccessory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalAccessory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalAccessory[]    findAll()
 * @method AnimalAccessory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalAccessoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalAccessory::class);
    }

    // /**
    //  * @return AnimalAccessory[] Returns an array of AnimalAccessory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnimalAccessory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
