<?php

namespace App\Controller;

use App\Entity\Salas;
use App\Form\SalasType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalasController extends AbstractController
{
    /**
     * @Route("/salas", name="salas")
     */
    public function index(): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        //Mostramos todas las SALAS
        $salas = $em -> getRepository(Salas::class) -> findAll();
        //Mostramos solo la SALA con ID definido
        $sala = $em -> getRepository(Salas::class) -> find(3);
        //Mostramos UNA la SALA con NOMBRE Iliada
        $salaNombre = $em -> getRepository(Salas::class) -> findOneBy([
            'nombre' => 'Leonidas'
        ]);
        $salaVarios = $em -> getRepository(Salas::class) -> findBy([
            'nombre' => 'La Iliada'
        ]);


        return $this->render('salas/index.html.twig', [
            'controller_name' => 'Salas Controller',
            'verSalas' => $salas,
            'verUnaSala' => $sala,
            'verPoNombre' => $salaNombre,
            'verVariosNombre' => $salaVarios
        ]);
    }

    /**
     * @Route("/salas/nueva_sala", name="Nueva_sala")
     */
    public function crearSala(Request $request): Response
    {
        $sala = new Salas();
        $form = $this -> createForm(SalasType::class, $sala);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($sala);
            $em -> flush();
            $this -> addFlash('success', Salas::REGISTRO_EXITOSO);

            return $this -> redirectToRoute('Nueva_sala');
        }

        return $this -> render('salas/crearSala.html.twig', [
            'controller_name' => 'Crear Nueva Sala',
            'formularioSalas' => $form -> createView()
        ]);
    }
}
