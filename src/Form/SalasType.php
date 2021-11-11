<?php

namespace App\Form;

use App\Entity\Centro;
use App\Entity\Salas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class,[
                //'block_name' => 'custom_name',
                'label' => 'Nombre de Sala'
            ])
            ->add('centro', EntityType::class,[
                'placeholder' => "Seleccione un Centro",
                'class' => Centro::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
            ])
            //->add('registrar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salas::class,
        ]);
    }
}
