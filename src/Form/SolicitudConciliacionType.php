<?php

namespace App\Form;

use App\Entity\SolicitudConciliacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolicitudConciliacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('materia')
            ->add('tipoConciliacion')
            ->add('fecha')
            ->add('solicitante')
            ->add('casoConciliatorio')
            //->add('usuario')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolicitudConciliacion::class,
        ]);
    }
}
