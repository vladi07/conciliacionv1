<?php

namespace App\Repository;

use App\Entity\Centro;
use App\Entity\Usuarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Centro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centro[]    findAll()
 * @method Centro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centro::class);
    }

    public function BuscarTodosCentros(){
       /* return $this -> getEntityManager()
            ->createQuery('
                SELECT centro.id, centro.nombre, centro.direccion, centro.matricula, 
                       centro.tipo, centro.telefono, centro.correo
                FROM App:Centro centro   
            ') ; */
        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->addSelect('c.nombre')
            ->addSelect('c.direccion')
            ->addSelect('c.matricula')
            ->addSelect('c.tipo')
            ->addSelect('c.telefono')
            ->addSelect('c.correo')
            ->addSelect('d.nombre AS nombreDepartamento')
            ->leftJoin('c.departamento','d')
            ->orderBy('c.id','DESC')
            ->getQuery();
    }

    // /**
    //  * @return Centro[] Returns an array of Centro objects
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
    public function findOneBySomeField($value): ?Centro
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
