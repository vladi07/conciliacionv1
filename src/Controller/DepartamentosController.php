<?php

namespace App\Controller;

use App\Entity\Departamentos;
use App\Form\DepartamentosType;
use App\Repository\DepartamentosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/departamentos")
 */
class DepartamentosController extends AbstractController
{
    /**
     * @Route("/", name="departamentos_index", methods={"GET"})
     */
    public function index(DepartamentosRepository $departamentosRepository): Response
    {
        return $this->render('departamentos/index.html.twig', [
            'departamentos' => $departamentosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="departamentos_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $departamento = new Departamentos();
        $form = $this->createForm(DepartamentosType::class, $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($departamento);
            $entityManager->flush();

            return $this->redirectToRoute('departamentos_index');
        }

        return $this->render('departamentos/new.html.twig', [
            //'departamento' => $departamento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="departamentos_show", methods={"GET"})
     */
    public function show(Departamentos $departamento): Response
    {
        return $this->render('departamentos/show.html.twig', [
            'departamento' => $departamento,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="departamentos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Departamentos $departamento): Response
    {
        $form = $this->createForm(DepartamentosType::class, $departamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('departamentos_index');
        }

        return $this->render('departamentos/edit.html.twig', [
            'departamento' => $departamento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="departamentos_delete", methods={"POST"})
     */
    public function delete(Request $request, Departamentos $departamento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departamento->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($departamento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('departamentos_index');
    }
}