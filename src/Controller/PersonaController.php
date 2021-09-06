<?php

namespace App\Controller;

use App\Entity\Departamentos;
use App\Entity\Persona;
use App\Entity\Usuarios;
use App\Form\CentroType;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/persona")
 */
class PersonaController extends AbstractController
{
    /**
     * @Route ("/", name="persona_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request, PersonaRepository $personaRepository): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        $consulta = $em -> getRepository(Persona::class) -> TodasPersonas();

        $pagination = $paginator -> paginate(
            $consulta,
            $request -> query -> getInt('page',1),3
        );

        return $this -> render('persona/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route ("/nuevo", name="nueva_persona", methods={"GET","POST"})
     */
    public function nuevo(Request $request): Response
    {
        //Creamos un objeto de tipo "persona"
        $persona = new Persona();
        //Creamos el formulario ("primer parametroPERSONATYPE","parametro que creamos$PERSONA")
        $form = $this->createForm(PersonaType::class, $persona);
        //Verificamos que el formulario fue enviado, pasamos como parametro el ($request)
        $form -> handleRequest($request);

        //Verificamos que los datos sean validos y guradamos el formulario
        if($form -> isSubmitted() && $form->isValid()){
            //CARGAR ARCHIVO PARA LA FOTO DE PERFIL
            /** @var UploadedFile $fotoArchivo */
            $fotoArchivo = $form->get('foto')->getData();
            // esta condición es necesaria porque el campo 'foto' no es obligatorio
            // por lo que el archivo PDF debe procesarse solo cuando se carga un archivo
            if ($fotoArchivo) {
                $originalFilename = pathinfo($fotoArchivo->getClientOriginalName(), PATHINFO_FILENAME);
                // esto es necesario para incluir de forma segura el nombre del archivo como parte de la URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',$originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoArchivo->guessExtension();

                // Move the file to the directory where brochures are stored
                // Mover el archivo a el directorio donde se almacenan los folletos
                try {
                    $fotoArchivo->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    //throw new \Exception('Lo siento!. Ha occurido un error');
                }
                // actualiza la propiedad 'newFilename' para almacenar el nombre del archivo PDF
                // en lugar de su contenido
                $persona->setFoto($newFilename);
            }

            //EntityManager crea, persiste, edita, revomer, eliminar o buscar en la base de datos
            $em = $this-> getDoctrine()->getManager();
            //Persistir el objeto $persona
            $em -> persist($persona);
            $em -> flush();
            //Retornamos una redireccion edireccionamos a la ventana principal
            return $this -> redirectToRoute('persona_index');

            // Mensaje de registro exitoso y como parametros
            // La llave es "success", la constante registrado la entidad
            //$this -> addFlash('success', Persona::REGISTRO_EXITOSO);
        }

        return $this->render('persona/nuevo.html.twig', [
            //'Titulo Persona' => 'Registrar Persona',
            'form' => $form -> createView()
        ]);
    }

    /**
     * @Route ("/{id}", name="ver_persona", methods={"GET"})
     */
    public function ver($id, Persona $persona): Response
    {
        //Buscamos una persona que reciva el ID
        $em = $this -> getDoctrine() -> getManager();
        //mostramos el registro de la persona
        $persona = $em->getRepository(Persona::class)->find($id);
        //Mostramos en la vista el ID encontrado
        return $this->render('persona/ver.html.twig',[
            'verPersona'=>$persona,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editar_persona", methods={"GET","POST"})
     */
    public function edit(Request $request, Persona $persona): Response
    {
        $form = $this -> createForm(PersonaType::class, $persona);
        $form -> handleRequest($request);



        if ($form -> isSubmitted() && $form -> isValid()){
            $this -> getDoctrine() -> getManager() -> flush();

            //CARGAR ARCHIVO PARA LA FOTO DE PERFIL
            /** @var UploadedFile $fotoArchivo */
            $fotoArchivo = $form->get('foto')->getData();
            // esta condición es necesaria porque el campo 'foto' no es obligatorio
            // por lo que el archivo PDF debe procesarse solo cuando se carga un archivo
            if ($fotoArchivo) {
                $originalFilename = pathinfo($fotoArchivo->getClientOriginalName(), PATHINFO_FILENAME);
                // esto es necesario para incluir de forma segura el nombre del archivo como parte de la URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',$originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoArchivo->guessExtension();

                // Move the file to the directory where brochures are stored
                // Mover el archivo a el directorio donde se almacenan los folletos
                try {
                    $fotoArchivo->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    //throw new \Exception('Lo siento!. Ha occurido un error');
                }
                // actualiza la propiedad 'newFilename' para almacenar el nombre del archivo PDF
                // en lugar de su contenido
                $persona->setFoto($newFilename);
            }

            //EntityManager crea, persiste, edita, revomer, eliminar o buscar en la base de datos
            $em = $this-> getDoctrine()->getManager();
            //Persistir el objeto $persona
            $em -> persist($persona);
            $em -> flush();

            return $this -> redirectToRoute('persona_index');
        }

        /*
        $persona -> setFoto(
            new File($this -> getParameter('photos_directory').'/'.$persona -> getFoto())
        );
        */

        return $this -> render('persona/editar.html.twig', [
            'verPersona' =>  $persona,
            'form' => $form -> createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eliminar_persona", methods={"POST"})
     */
    public function delete(Request $request, Persona $persona): Response
    {
        if ($this -> isCsrfTokenValid('delete'.$persona->getId(), $request->request->get('_token'))) {
            $em = $this -> getDoctrine() -> getManager();
            $em -> remove($persona);
            $em -> flush();
        }
        return $this -> redirectToRoute('persona_index');
    }

    /**
     * @Route ("/mis_companeros", name="compañeros")
     */
    public function MisPersonas(){
        $em = $this->getDoctrine()->getManager();
        $departamento = $this->getUser();

        return $this -> redirectToRoute('persona_index');
    }

}