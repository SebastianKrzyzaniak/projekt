<?php

namespace App\Repository;

use App\Entity\Uzytkownicy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Uzytkownicy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uzytkownicy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uzytkownicy[]    findAll()
 * @method Uzytkownicy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UzytkownicyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Uzytkownicy::class);
    }

    // /**
    //  * @return Uzytkownicy[] Returns an array of Uzytkownicy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Uzytkownicy
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
