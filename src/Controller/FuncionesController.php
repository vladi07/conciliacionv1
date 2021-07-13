<?php

namespace App\Controller;

use App\Entity\Funciones;
use App\Form\FuncionesType;
use App\Repository\FuncionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/funciones")
 */
class FuncionesController extends AbstractController
{
    /**
     * @Route("/", name="funciones_index", methods={"GET"})
     */
    public function index(FuncionesRepository $funcionesRepository): Response
    {
        return $this->render('funciones/index.html.twig', [
            'funciones' => $funcionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nuevo", name="nueva_funcion", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $funcione = new Funciones();
        $form = $this->createForm(FuncionesType::class, $funcione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($funcione);
            $entityManager->flush();

            return $this->redirectToRoute('funciones_index');
        }

        return $this->render('funciones/new.html.twig', [
            'funcione' => $funcione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ver_funcion", methods={"GET"})
     */
    public function show(Funciones $funcione): Response
    {
        return $this->render('funciones/show.html.twig', [
            'funcione' => $funcione,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editar_funcion", methods={"GET","POST"})
     */
    public function edit(Request $request, Funciones $funcione): Response
    {
        $form = $this->createForm(FuncionesType::class, $funcione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('funciones_index');
        }

        return $this->render('funciones/edit.html.twig', [
            'funcione' => $funcione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eliminar_funcion", methods={"POST"})
     */
    public function delete(Request $request, Funciones $funcione): Response
    {
        if ($this->isCsrfTokenValid('delete'.$funcione->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($funcione);
            $entityManager->flush();
        }

        return $this->redirectToRoute('funciones_index');
    }
}
