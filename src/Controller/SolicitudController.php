<?php

namespace App\Controller;

use App\Entity\SolicitudConciliacion;
use App\Form\SolicitudConciliacionType;
use App\Repository\SolicitudConciliacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/solicitud")
 */
class SolicitudController extends AbstractController
{
    /**
     * @Route("/", name="solicitud_index", methods={"GET"})
     */
    public function index(SolicitudConciliacionRepository $solicitudConciliacionRepository): Response
    {
        return $this->render('solicitud/index.html.twig', [
            'solicitudes' => $solicitudConciliacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="solicitud_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nuevoSolicitante = new ArrayCollection();



        $solicitudConciliacion = new SolicitudConciliacion();
        $form = $this->createForm(SolicitudConciliacionType::class, $solicitudConciliacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudConciliacion);
            $entityManager->flush();

            return $this->redirectToRoute('solicitud_index');
        }

        return $this->render('solicitud/new.html.twig', [
            'solicitud_conciliacion' => $solicitudConciliacion,
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="solicitud_show", methods={"GET"})
     */
    public function show(SolicitudConciliacion $solicitudConciliacion): Response
    {
        return $this->render('solicitud/show.html.twig', [
            'solicitud_conciliacion' => $solicitudConciliacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="solicitud_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SolicitudConciliacion $solicitudConciliacion): Response
    {
        $form = $this->createForm(SolicitudConciliacionType::class, $solicitudConciliacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('solicitud_index');
        }

        return $this->render('solicitud/edit.html.twig', [
            'solicitud_conciliacion' => $solicitudConciliacion,
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="solicitud_delete", methods={"POST"})
     */
    public function delete(Request $request, SolicitudConciliacion $solicitudConciliacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solicitudConciliacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($solicitudConciliacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('solicitud_index');
    }
}
