<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Entity\Usuarios;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonaController extends AbstractController
{
    /**
     * @Route("/registrar_persona", name="Registrar_Personas")
     */
    public function index(Request $request): Response
    {
        //Creamos un objeto de tipo "persona"
        $persona = new Persona();
        //Creamos el formulario ("primer parametroPERSONATYPE","parametro que creamos$PERSONA")
        $form = $this->createForm(PersonaType::class, $persona);
        //Verificamos que el formulario fue enviado, pasamos como parametro el ($request)
        $form -> handleRequest($request);

        //Verificamos que los datos sean validos y guradamos el formulario
        if($form -> isSubmitted() && $form->isValid()){
            /** @var UploadedFile $fotoArchivo */
            $fotoArchivo = $form->get('foto')->getData();

            if ($fotoArchivo) {
                $originalFilename = pathinfo($fotoArchivo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',$originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoArchivo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fotoArchivo->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    //throw new \Exception('Lo siento!. Ha occurido un error');
                }

                $persona->setFoto($newFilename);
            }

            //EntityManager crea, persiste, edita, revomer, eliminar o buscar en la base de datos
            $em = $this-> getDoctrine()->getManager();
            //Persistir el objeto $persona
            $em -> persist($persona);
            $em -> flush();

            // Mensaje de registro exitoso y como parametros
            // La llave es "success", la constante registrado la entidad
            $this -> addFlash('success', Persona::REGISTRO_EXITOSO);

            //Retornamos una redireccion edireccionamos a la ventana principal
            return $this -> redirectToRoute('Registrar_Personas');

        }
        return $this->render('persona/index.html.twig', [
            'controller_name' => 'Registrar Persona',
            'formulario' => $form -> createView()
        ]);
    }

    /**
     * @Route ("/persona/{id}", name="Ver_Persona")
     */
    public function VerPersona($id){
        //Buscamos una persona que reciva el ID
        $em = $this -> getDoctrine() -> getManager();
        //mostramos el registro de la persona
        $persona = $em->getRepository(Persona::class)->find($id);
        //Mostramos en la vista el ID encontrado
        return $this->render('persona/verPersona.html.twig',['resultado'=>$persona]);
    }

    /**
     * @Route ("/mis_personas", name="Mis_Personas")
     */
    public function MisPersonas(){
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
    }


    /**
     * @Route("/perfil/{id}", name="Perfil_Usuario", methods={"GET","POST"})
     */
    public function VerPerfil($id): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        $perfil = $em -> getRepository(Persona::class) -> find($id);

        return $this -> render('Perfil/verPerfil.html.twig', [
            'vista_perfil' => $perfil
        ]);
    }

    /**
     * @Route("/perfil/{id}/editar", name="Editar_Perfil", methods={"GET","POST"})
     */
    public function EditarPerfil(Request $request, Persona $persona, Usuarios $usuarios): Response
    {
        $form = $this -> createForm(PersonaType::class, $persona);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this -> redirectToRoute('Perfil_Usuario');
        }

        return $this -> render('Perfil/editarPerfil.html.twig', [
           'vista_editar_perfil' => $persona,
           'form' => $form -> createView(),
        ]);
    }
}
