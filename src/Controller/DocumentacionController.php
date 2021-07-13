<?php

namespace App\Controller;

use App\Entity\Documentacion;
use App\Form\DocumentacionType;
use App\Repository\DocumentacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/documentacion")
 */
class DocumentacionController extends AbstractController
{
    /**
     * @Route("/", name="documentacion_index", methods={"GET"})
     */
    public function index(DocumentacionRepository $documentacionRepository): Response
    {
        return $this->render('documentacion/index.html.twig', [
            'documentacions' => $documentacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="documentacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $documentacion = new Documentacion();
        $form = $this->createForm(DocumentacionType::class, $documentacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documentacion);
            $entityManager->flush();

            return $this->redirectToRoute('documentacion_index');
        }

        return $this->render('documentacion/new.html.twig', [
            'documentacion' => $documentacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="documentacion_show", methods={"GET"})
     */
    public function show(Documentacion $documentacion): Response
    {
        return $this->render('documentacion/show.html.twig', [
            'documentacion' => $documentacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="documentacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Documentacion $documentacion): Response
    {
        $form = $this->createForm(DocumentacionType::class, $documentacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('documentacion_index');
        }

        return $this->render('documentacion/edit.html.twig', [
            'documentacion' => $documentacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="documentacion_delete", methods={"POST"})
     */
    public function delete(Request $request, Documentacion $documentacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($documentacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('documentacion_index');
    }
}
