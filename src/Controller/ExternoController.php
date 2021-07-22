<?php

namespace App\Controller;

use App\Entity\UsuarioExterno;
use App\Form\UsuarioExternoType;
use App\Repository\UsuarioExternoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/externo")
 */
class ExternoController extends AbstractController
{
    /**
     * @Route("/", name="externo_index", methods={"GET"})
     */
    public function index(UsuarioExternoRepository $usuarioExternoRepository): Response
    {
        return $this->render('externo/index.html.twig', [
            'usuario_externos' => $usuarioExternoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="externo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $usuarioExterno = new UsuarioExterno();
        $form = $this->createForm(UsuarioExternoType::class, $usuarioExterno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuarioExterno);
            $entityManager->flush();

            return $this->redirectToRoute('externo_index');
        }

        return $this->render('externo/new.html.twig', [
            'usuario_externo' => $usuarioExterno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="externo_show", methods={"GET"})
     */
    public function show(UsuarioExterno $usuarioExterno): Response
    {
        return $this->render('externo/show.html.twig', [
            'usuario_externo' => $usuarioExterno,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="externo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UsuarioExterno $usuarioExterno): Response
    {
        $form = $this->createForm(UsuarioExternoType::class, $usuarioExterno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('externo_index');
        }

        return $this->render('externo/edit.html.twig', [
            'usuario_externo' => $usuarioExterno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="externo_delete", methods={"POST"})
     */
    public function delete(Request $request, UsuarioExterno $usuarioExterno): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuarioExterno->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuarioExterno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('externo_index');
    }
}
