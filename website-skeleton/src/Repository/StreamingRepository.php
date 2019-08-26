<?php

namespace App\Repository;

use App\Entity\Streaming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Streaming|null find($id, $lockMode = null, $lockVersion = null)
 * @method Streaming|null findOneBy(array $criteria, array $orderBy = null)
 * @method Streaming[]    findAll()
 * @method Streaming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Streaming::class);
    }

    // /**
    //  * @return Streaming[] Returns an array of Streaming objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Streaming
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
