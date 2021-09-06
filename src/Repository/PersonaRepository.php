<?php

namespace App\Repository;

use App\Entity\Persona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Persona|null find($id, $lockMode = null, $lockVersion = null)
 * @method Persona|null findOneBy(array $criteria, array $orderBy = null)
 * @method Persona[]    findAll()
 * @method Persona[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persona::class);
    }

    // Creamos la funcion "BUSCAR PERSONA" con la ayuda de un query
    // Llamamos a esta funcion en el CONTROLLER donde queremos mostrar el resultado -> PrincipalController
    public function TodasPersonas(){
        /*
        return $this -> getEntityManager()
            ->createQuery('
                SELECT persona.id, persona.nombres, persona.primerApellido, persona.numeroDocumento,
                        persona.fechaNacimiento, persona.foto
                FROM App:Persona persona
            ');
        */
        return $this -> createQueryBuilder('p')
            -> select('p.id')
            -> addSelect('p.nombres')
            -> addSelect('p.primerApellido')
            -> addSelect('p.segundoApellido')
            -> addSelect('p.numeroDocumento')
            -> addSelect('p.expedido')
            -> addSelect('p.fechaNacimiento')
            -> addSelect('p.genero')
            -> addSelect('p.correo')
            -> addSelect('p.telefono')
            -> addSelect('p.gradoAcademico')

            -> leftJoin('p.departamento', 'd')
            -> addSelect('d.nombre AS nombreDepartamento')

            -> addSelect('p.domicilio')
            -> addSelect('p.foto')
            -> orderBy('p.nombres', 'ASC')

            -> getQuery();
    }


    // /**
    //  * @return Persona[] Returns an array of Persona objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Persona
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
