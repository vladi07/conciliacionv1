<?php

namespace App\Form;

use App\Entity\Centro;
use App\Entity\Departamentos;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
/* use Symfony\Component\Form\Extension\Core\Type\SalasType; */

class CentroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('direccion', TextType::class,[
                'label' => 'Dirección'
            ])
            ->add('matricula')
            ->add('tipo', ChoiceType::class,[
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'Privado' => 'PRIVADO',
                    'Publico' => 'PUBLICO',
                ]
            ])
            ->add('telefono', NumberType::class, array(
                'label' => 'Número de Teléfono',
                'required' => true,
                'help' => 'Ingrese solo números enteros, sin ningun simbolo',
            ))
            ->add('correo', EmailType::class, [
                'help' => 'Ej. mi.correo@mail.com'
            ])
            ->add('departamento', EntityType::class,[
                'placeholder' => 'Seleccione una opción',
                'class' => Departamentos::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Centro::class,
        ]);
    }
}
