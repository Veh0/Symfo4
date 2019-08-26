<?php

namespace App\Repository;

use App\Entity\Actu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actu[]    findAll()
 * @method Actu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actu::class);
    }

    public function findByUserId($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.userId = :id') ->setParameter('id', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Actu
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
