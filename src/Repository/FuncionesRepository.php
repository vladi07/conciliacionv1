<?php

namespace App\Repository;

use App\Entity\Funciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Funciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Funciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Funciones[]    findAll()
 * @method Funciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuncionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Funciones::class);
    }

    // /**
    //  * @return Funciones[] Returns an array of Funciones objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Funciones
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
