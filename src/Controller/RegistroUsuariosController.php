<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Entity\Usuarios;
use App\Form\UsuariosType;
use App\Repository\UsuarioExternoRepository;
use App\Repository\UsuariosRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/", name="usuario_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request, UsuariosRepository $usuariosRepository): Response
    {
        //Creamos las restricciones para acceder al formulario del sistema
        //$this->denyAccessUnlessGranted("ROLE_ADMIN_AJAN");

        $em = $this -> getDoctrine() -> getManager();
        $consulta = $em -> getRepository(Usuarios::class) -> TodosUsuarios();

        $pagination= $paginator -> paginate(
            $consulta,
            $request -> query ->getInt('page',1),3
        );

        return $this -> render('registro_usuarios/index.html.twig',[
            /*
            'usuarios' => $usuarioExternoRepository -> findAll(),
            */
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/nuevo", name="nuevo_usuario", methods={"GET","POST"})
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
            // Asignamos ROLES
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

            return $this -> redirectToRoute('usuario_index');
        }
        // Mostramos los datos en el TEMPLATE del controlador
        return $this -> render('registro_usuarios/nuevo.html.twig', [
            //'controller_name' => 'Lista de los Usuarios',
            'form' => $form -> createView()
        ]);
    }

    /**
     * @Route ("/{id}", name="ver_usuario", methods={"GET"})
     */
    public function ver(Usuarios $usuarios): Response
    {
        return $this -> render('registro_usuarios/ver.html.twig',[
           'verUsuario' => $usuarios,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editar_usuario", methods={"GET","POST"})
     */
    public function editar(Request $request, Usuarios $usuarios): Response
    {
        $form = $this -> createForm(UsuariosType::class, $usuarios);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()){
            $this -> getDoctrine() -> getManager() -> flush();

            return $this -> redirectToRoute('usuario_index');
        }

        return $this -> render('registro_usuarios/editar.html.twig',[
            'verUsuario' => $usuarios,
            'form' => $form -> createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eliminar_usuario", methods={"POST"})
     */
    public function delete(Request $request, Usuarios $usuarios): Response
    {
        if ($this -> isCsrfTokenValid('delete'.$usuarios->getId(), $request->request->get('_token'))){
            $em = $this -> getDoctrine() -> getManager();
            $em -> remove($usuarios);
            $em -> flush();
        }
        return $this -> redirectToRoute('usuario_index');
    }

}
