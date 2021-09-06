<?php

namespace App\Form;

use App\Entity\Actividad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción'
            ])
            ->add('fecha', DateType::class,[
                'widget' => 'single_text'
            ])
            /*
            ->add('centro')
            */

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actividad::class,
        ]);
    }
}
