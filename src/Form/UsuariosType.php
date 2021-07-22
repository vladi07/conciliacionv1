<?php

namespace App\Form;

use App\Entity\Persona;
use App\Entity\Usuarios;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Usuario'])
            ->add('password', PasswordType::class, ['label' => 'Contraseña'])
            ->add('estado', CheckboxType::class, [
                'label' => '¿Desea activar este usuario?',
                'required' => false,
            ])
            ->add('rolAsignado',ChoiceType::class,[
                'mapped'=>false,
                'placeholder'=>'por favor seleccione un rol',
                'choices'=>[
                    'ADMINISTRADOR'=>1,
                    'CONCILUADOR'=>2,
                    'SECRETRIA'=>3
                ]
            ])
            //->add('creadoPor')
            //->add('persona', EntityType::class, [
                //'class' => Persona::class,
            //])
            //->add('centro')
            ->add('Registrar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuarios::class,
        ]);
    }
}
