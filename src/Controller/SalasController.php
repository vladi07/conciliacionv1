<?php

namespace App\Controller;

use App\Entity\Salas;
use App\Form\SalasType;
use App\Repository\SalasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/sala")
 */
class SalasController extends AbstractController
{
    /**
     * @Route("/", name="sala_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request, SalasRepository $salasRepository): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        $query = $em -> getRepository(Salas::class) -> TodoSalas();

        $pagination = $paginator -> paginate(
            $query,
            $request->query->getInt('page',1),5
        );

        return $this -> render('salas/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/nuevo", name="nueva_sala", methods={"GET","POST"})
     */
    public function nuevo(Request $request): Response
    {
        $sala = new Salas();
        $form = $this -> createForm(SalasType::class,$sala);
        $form-> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($sala);
            $em -> flush();

            $this -> addFlash('success', Salas::REGISTRO_EXITOSO);

            return $this -> redirectToRoute('sala_index');
        }

        return $this->render('salas/nuevo.html.twig',[
            'formSala' => $form -> createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ver_sala", methods={"GET"})
     */
    public function ver(Salas $salas, Request $request): Response
    {
        return $this -> render('salas/ver.html.twig', [
            'verSala' => $salas,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editar_sala", methods={"GET","POST"})
     */
    public function edit(Request $request, Salas $salas ): Response
    {
        $form = $this -> createForm(SalasType::class, $salas);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()){
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sala_index');
        }
        return $this->render('salas/editar.html.twig',[
            'formSala' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eliminar_sala", methods={"POST"})
     */
    public function delete(Request $request, Salas $salas): Response
    {
        if ($this -> isCsrfTokenValid('delete'.$salas->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salas);
            $em->flush();
        }
        return $this->redirectToRoute('sala_index');
    }
}