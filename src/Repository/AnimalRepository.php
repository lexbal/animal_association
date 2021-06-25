<?php

namespace App\Repository;

use App\Entity\Animal;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * @return mixed
     */
    public function findByEightAnimalNotAdopted()
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.adopted = 0')
                    ->andWhere("a.adopted_at IS NULL")
                    ->setMaxResults(8)
                    ->getQuery()->getResult();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function findByAdoptedPreviousMonth()
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.adopted = 1')
                    ->andWhere("a.adopted_at > :startDate")
                    ->andWhere("a.adopted_at < :endDate")
                    ->setParameter(':endDate', new DateTime('last day of last month'))
                    ->setParameter(':startDate', new DateTime('first day of last month'))
                    ->getQuery()->getResult();
    }

    // /**
    //  * @return Animal[] Returns an array of Animal objects
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
    public function findOneBySomeField($value): ?Animal
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
