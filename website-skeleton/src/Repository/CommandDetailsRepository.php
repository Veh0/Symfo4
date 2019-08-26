<?php

namespace App\Repository;

use App\Entity\CommandDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandDetails[]    findAll()
 * @method CommandDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandDetailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandDetails::class);
    }

    // /**
    //  * @return CommandDetails[] Returns an array of CommandDetails objects
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
    public function findOneBySomeField($value): ?CommandDetails
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
