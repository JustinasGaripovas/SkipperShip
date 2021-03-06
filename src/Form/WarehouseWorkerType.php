<?php

namespace App\Form;

use App\Entity\WarehouseWorker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WarehouseWorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseUser', UserType::class, [
                'label' => false,
            ])
            ->add('warehouse')
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WarehouseWorker::class,
        ]);
    }
}
