<?php

namespace App\Form;

use App\Entity\Departamentos;
use App\Entity\Persona;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\PropertyAccess\PropertyPath;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres', TextType::class,[
                'label' => 'Nombre(s)'
            ])
            ->add('primerApellido', TextType::class, [
                'label' => 'Primer Apellido'
            ])
            ->add('segundoApellido')
            ->add('numeroDocumento', NumberType::class, [
                'label' => 'Documento de Identidad',
                'help' => 'Ingrese solo números',
            ])
            ->add('expedido', ChoiceType::class,[
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'LP' => 'La Paz',
                    'CB' => 'Cochabamba',
                    'BE' => 'Beni',
                    'SZ' => 'Santa Cruz',
                    'TJ' => 'Tarija',
                    'CH' => 'Chuquisaca',
                    'PO' => 'Potosi',
                    'OR' => 'Oruro',
                    'PD' => 'Pando',
                ]
            ])
            ->add('fechaNacimiento', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('genero',ChoiceType::class,[
                'label' => 'Género',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'FEMENINO' => 'Femenino',
                    'MASCULINO' => 'Masculino'
                ]
            ])
            ->add('correo', EmailType::class,[
                'required' => false
            ])
            ->add('telefono', NumberType::class,[
                'label' => 'Teléfono o Celular',
                'required' => false
            ] )
            ->add('gradoAcademico', ChoiceType::class,[
                'label' => 'Grado Academico',
                'placeholder' => 'Selecciones una opción',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'PRIMARIA' => 'Primaria',
                    'SECUNDARIA' => 'Secundaria',
                    'TÉCNICO' => 'Tecnico',
                    'LICENCIATURA' => 'Licenciatura',
                    'MAESTRIA' => 'Maestria',
                    'DOCTORADO' => 'Doctorado',
                    'NINGUNO' => 'Ninguno'
                ]
            ])
            ->add('domicilio', TextType::class)
            ->add('departamento',EntityType::class,[
                'placeholder' => 'Seleccione una opción',
                'class' => Departamentos::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('foto', FileType::class, [
                'label' => 'Foto de Perfil',
                // sin asignar significa que este campo no está asociado a ninguna propiedad de entidad
                'mapped' => false,
                // hágalo opcional para que no tenga que volver a cargar el archivo PDF
                // cada vez que edita los detalles del producto
                'required' => false,
                'help' => 'Seleccione un archivo PNG o JPG'
                // los campos no asignados no pueden definir su validación mediante anotaciones
                // en la entidad asociada, para que pueda usar las clases de restricción de PHP
            ])
            /*
             ->add('Registrar', SubmitType::class)
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
