<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroUsuariosController extends AbstractController
{
    private $permisos=[
        1=>[
            'ROLE_ASDASd',
            'ROLE_ASDASDAsd',
            'ROLE_123123'
        ],
        2=>['ROLE_USUUAUAUA'],
        3=>[]
    ];
    /**
     * @Route("/registro_usuarios", name="Registrar_Usuarios")
     *
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted("ROLE_123123");
        $usuario = new Usuarios();
        $form = $this -> createForm(UsuariosType::class, $usuario);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()){
            // PersonaId lo extraemos de la relacion
            // CentroId lo extraemos de la relacion

            //Encriptamos el password
            $usuario -> setPassword($passwordEncoder -> encodePassword(
                $usuario, $form['password'] -> getData()
            ));
            $rolAsignado=$form['rolAsignado']->getData();
            $usuario->setRoles($this->permisos[$rolAsignado]);

            // Creamos el Usuario Creador
            //$usuarioCreador = $this->getUser();
            //$usuario -> setCreadoPor($usuarioCreador);

            // Le damos el valor de fecha y hora del sistema en el campo "Fecha Creacion"
            // YA SE CREO ESTE CAMPO EN LA ENTIDAD "USUARIOS"
            //$ahora = new \DateTime('now');
            //$usuario -> setFechaCreacion($ahora);

            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($usuario);
            $em -> flush();
            //Mostramos un mensaje personalizado en la parte superior del TEMPLATE
            $this -> addFlash('exito', Usuarios::REGISTRO_EXITOSO);

            return $this -> redirectToRoute('Registrar_Usuarios');
        }
        // Mostramos los datos en el TEMPLATE del controlador
        return $this -> render('registro_usuarios/index.html.twig', [
            'controller_name' => 'Módulo de Administración de Usuarios',
            'formulario' => $form -> createView()
        ]);
    }
}
