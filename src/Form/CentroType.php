<?php

namespace App\Form;

use App\Entity\Centro;
use App\Entity\Departamentos;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('direccion')
            ->add('matricula')
            ->add('tipo', ChoiceType::class,[
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'Privado' => 'PRIVADO',
                    'Publico' => 'PUBLICO',
                ]
            ])
            ->add('telefono')
            ->add('correo')
            ->add('departamento', EntityType::class,[
                'placeholder' => 'Seleccione una opción',
                'class' => Departamentos::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Centro::class,
        ]);
    }
}
