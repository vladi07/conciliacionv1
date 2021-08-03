<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use App\Repository\UsuarioExternoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/usuarios")
 */
class RegistroUsuariosController extends AbstractController
{
    private $permisos=[
        1=>[
            'ROLE_ADMIN_AJAN',
            'ROLE_ADMIN_CENTRO',
            'ROLE_CONCILIADOR',
            'ROLE_SECRETARIA'
        ],
        2=>['ROLE_ADMIN_CENTRO',
            'ROLE_CONCILIADOR',
            'ROLE_SECRETARIA'
        ],
        3=>['ROLE_CONCILIADOR',
            'ROLE_SECRETARIA'
        ],
        4=>['ROLE_SECRETARIA']
    ];

    /**
     * @Route("/", name="Lista_Usuarios", methods={"GET"})
     */
    public function index(UsuarioExternoRepository $usuarioExternoRepository): Response
    {
        //Creamos las restricciones para acceder al formulario del sistema
        //$this->denyAccessUnlessGranted("ROLE_ADMIN_AJAN");

        return $this -> render('registro_usuarios/index.html.twig',[
            'usuarios' => $usuarioExternoRepository -> findAll(),
        ]);
    }

    /**
     * @Route("/nuevo_usuario", name="Nuevo_Usuario")
     *
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$this->denyAccessUnlessGranted("ROLE_123123");
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

            return $this -> redirectToRoute('Lista_Usuarios');
        }
        // Mostramos los datos en el TEMPLATE del controlador
        return $this -> render('registro_usuarios/index.html.twig', [
            'controller_name' => 'Lista de los Usuarios',
            'formulario' => $form -> createView()
        ]);
    }
}
