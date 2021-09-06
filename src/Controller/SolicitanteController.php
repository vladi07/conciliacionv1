<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SolicitanteController extends AbstractController
{
    /**
     * @Route("/solicitante", name="solicitante")
     */
    public function index(): Response
    {
        return $this->render('solicitante/index.html.twig', [
            'controller_name' => 'SolicitanteController',
        ]);
    }
}
