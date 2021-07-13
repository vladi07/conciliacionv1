<?php

namespace App\Repository;

use App\Entity\SolicitudConciliacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolicitudConciliacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitudConciliacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitudConciliacion[]    findAll()
 * @method SolicitudConciliacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudConciliacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitudConciliacion::class);
    }

    public function BuscarSolcicitudes(){
        return $this -> getEntityManager()
            ->createQuery('
              SELECT solicitud_conciliacion.id, 
                    solicitud_conciliacion.descripcion, 
                    solicitud_conciliacion.materia,
                    solicitud_conciliacion.tipo_conciliacion, 
                    solicitud_conciliacion.fecha,
                    usuarios.username 
              FROM App:SolicitudConciliacion solicitud
              JOIN solicitud_conciliacion.usuario
            ');
    }

    // /**
    //  * @return SolicitudConciliacion[] Returns an array of SolicitudConciliacion objects
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
    public function findOneBySomeField($value): ?SolicitudConciliacion
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
