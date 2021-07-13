<?php

namespace App\Controller;

use App\Entity\Persona;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/principal", name="Principal")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        //$personas = $em -> getRepository(Persona::class) -> findAll();
        //$verPersona = $em -> getRepository(Persona::class) -> find(5);
        //$personalizado1 = $em -> getRepository(Persona::class)
        //-> findOneBy(['nombres'=>'Carola Alejandra']);
        //$personalizado2 = $em -> getRepository(Persona::class)
        //-> findBy(['primerApellido'=>'Perez']);
        $query = $em->getRepository(Persona::class)->BuscarPersonas();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('principal/index.html.twig', [
            //'personas' => $personas,
            //'verPersona' => $verPersona,
            //'personal1' => $personalizado1,
            //'personal2' => $personalizado2,
            'pagination' => $pagination
        ]);
    }
}
