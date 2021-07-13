<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Form\ActividadType;
use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actividad")
 */
class ActividadController extends AbstractController
{
    /**
     * @Route("/", name="actividad_index", methods={"GET"})
     */
    public function index(ActividadRepository $actividadRepository): Response
    {
        return $this->render('actividad/index.html.twig', [
            'actividads' => $actividadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="actividad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actividad = new Actividad();
        $form = $this->createForm(ActividadType::class, $actividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actividad);
            $entityManager->flush();

            return $this->redirectToRoute('actividad_index');
        }

        return $this->render('actividad/new.html.twig', [
            'actividad' => $actividad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actividad_show", methods={"GET"})
     */
    public function show(Actividad $actividad): Response
    {
        return $this->render('actividad/show.html.twig', [
            'actividad' => $actividad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actividad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actividad $actividad): Response
    {
        $form = $this->createForm(ActividadType::class, $actividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actividad_index');
        }

        return $this->render('actividad/edit.html.twig', [
            'actividad' => $actividad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actividad_delete", methods={"POST"})
     */
    public function delete(Request $request, Actividad $actividad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actividad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actividad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actividad_index');
    }
}
