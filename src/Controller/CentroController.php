<?php

namespace App\Controller;

use App\Entity\Centro;
use App\Entity\Salas;
use App\Form\CentroType;
use App\Form\SalasType;
use App\Repository\CentroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/{id}", name="centro_show")
     */
    public function show(Centro $centro,Request $request): Response
    {
        $form=$this->createForm(SalasType::class,null);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var Salas $sala */
            $sala =$form->getData();
            $sala->setCentro($centro);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sala);
            $entityManager->flush();
        }
        return $this->render('centro/show.html.twig', [
            'centro' => $centro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centro_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, EntityManagerInterface $entityManager, Centro $centro): Response
    {
        if (null == $centro = $entityManager->getRepository(Centro::class)->find($id)){
            throw $this -> createNotFoundException('No se encontro sala con el ID'.$id);
        }

        $originalSalas = new ArrayCollection();

        foreach ($centro -> getSala() as $sala){
            $originalSalas -> add($sala);
        }

        $editForm = $this -> createForm(CentroType::class, $centro);

        $editForm -> handleRequest($request);

        if ($editForm -> isSubmitted() && $editForm -> isValid()){
            foreach ($originalSalas as $sala){
                if (false === $centro -> getSala()-> contains($sala)){
                    $sala -> getCentro() -> removeElement($centro);
                    $entityManager -> persist($sala);
                }
            }

            $entityManager->persist($centro);
            $entityManager->flush();

            return $this->redirectToRoute('centro_edit', ['id'=>$id]);
        }

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
