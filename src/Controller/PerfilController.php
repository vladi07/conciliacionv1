<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilController extends AbstractController
{
    /**
     * @Route("/perfil", name="Perfil")
     */
    public function index(): Response
    {
        return $this->render('perfil/index.html.twig', [
            'controller_name' => 'Perfil de Usuario',
        ]);
    }
}
