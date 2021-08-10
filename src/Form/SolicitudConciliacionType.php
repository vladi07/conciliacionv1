<?php

namespace App\Form;

use App\Entity\SolicitudConciliacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolicitudConciliacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('materia', ChoiceType::class, [
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'Bancario' => 'BANCARIO',
                    'Civil' => 'VIRTUAL',
                    'Comercial' => 'COMERCIAL',
                    'Comunitario' => 'COMUNITARIO',
                    'Deportivo' => 'DEPORTIVO',
                    'Derecho' => 'DERECHO',
                    'Escolar' => 'ESCOLAR',
                    'Familiar' => 'FAMILIAR',
                    'Mercantil' => 'MERCANTIL',
                    'Municipal' => 'MUNICIPAL',
                    'Penal' => 'PENAL',
                    'Vecinal' => 'VECINAL',
                ]
            ])
            ->add('tipoConciliacion', ChoiceType::class,[
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'Presencial' => 'PRESENCIAL',
                    'Virtual' => 'VIRTUAL'
                ]
            ])
            //->add('fecha')
            //->add('solicitante')
            //->add('casoConciliatorio')
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
