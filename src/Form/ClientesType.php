<?php

namespace App\Form;

use App\Entity\Clientes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DNI')
            ->add('apellido')
            ->add('Nombre')
            ->add('telefono');
        
        // Si el formulario se utiliza para editar, agregar el campo de fecha como texto normal
        if ($options['is_edit']) {
            $builder->add('Fecha', null, [
                'label' => 'Fecha',
                'attr' => [
                    'readonly' => true, // Campo de solo lectura
                    'disabled' => true, // Deshabilitar el campo
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clientes::class,
            'is_edit' => false, // Por defecto, el formulario no es para editar
        ]);
    }
}
