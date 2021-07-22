<?php

namespace App\Form;

use App\Entity\UsuarioExterno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioExternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoUsuario')
            ->add('tipoDocumento')
            ->add('ordenJudicial')
            ->add('autoridadEmite')
            ->add('fechaEmision')
            ->add('creadoPor')
            ->add('fechaCreacion')
            ->add('persona')
            ->add('solicitud')
            ->add('casosConciliatorios')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UsuarioExterno::class,
        ]);
    }
}
