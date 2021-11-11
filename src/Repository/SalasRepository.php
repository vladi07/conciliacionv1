<?php

namespace App\Repository;

use App\Entity\Salas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salas[]    findAll()
 * @method Salas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salas::class);
    }

    public function TodoSalas(){
        return $this -> createQueryBuilder('sal')
            -> select('sal.id')
            -> addSelect('sal.nombre')
            -> addSelect('sal.fechaCreacion')

            -> leftJoin('sal.centro','cen')
            -> addSelect('cen.nombre AS nombreCentro')

            -> orderBy('sal.nombre', 'ASC')

            -> getQuery();
    }

    // /**
    //  * @return Salas[] Returns an array of Salas objects
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
    public function findOneBySomeField($value): ?Salas
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
