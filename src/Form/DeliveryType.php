<?php

namespace App\Form;

use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('recipientLat', HiddenType::class, [
                'required' => true
            ])
            ->add('recipientLng', HiddenType::class, [
                'required' => true
            ])
            ->add('weight')
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('recipientInformation')
            ->add('client', HiddenType::class)
            ->add('courier', HiddenType::class)
            ->add('warehouse', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
