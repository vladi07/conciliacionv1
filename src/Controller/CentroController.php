<?php

namespace App\Controller;

use App\Entity\Centro;
use App\Form\CentroType;
use App\Repository\CentroRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centro")
 */
class CentroController extends AbstractController
{
    /**
     * @Route("/", name="centro_index", methods={"GET"})
     */
    public function index( PaginatorInterface $paginator, Request $request, CentroRepository $centroRepository): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        $query = $em-> getRepository(Centro::class) -> BuscarTodosCentros() ;

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        return $this->render('centro/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="centro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centro = new Centro();
        $form = $this->createForm(CentroType::class, $centro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($centro);
            $entityManager->flush();

            return $this->redirectToRoute('centro_index');
        }

        return $this->render('centro/new.html.twig', [
            'centro' => $centro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centro_show", methods={"GET"})
     */
    public function show(Centro $centro): Response
    {
        return $this->render('centro/show.html.twig', [
            'centro' => $centro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centro $centro): Response
    {
        $form = $this->createForm(CentroType::class, $centro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centro_index');
        }

        return $this->render('centro/edit.html.twig', [
            'centro' => $centro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centro_delete", methods={"POST"})
     */
    public function delete(Request $request, Centro $centro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centro_index');
    }
}
