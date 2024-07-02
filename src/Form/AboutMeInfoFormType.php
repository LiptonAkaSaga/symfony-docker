<?php

namespace App\Form;

use App\Entity\AboutMeInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutMeInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('infoKey', TextType::class, [
                'label' => 'Klucz',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Wprowadź klucz'
                ]
            ])
            ->add('value', TextType::class, [
                'label' => 'Wartość',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Wprowadź wartość'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AboutMeInfo::class,
            'attr' => ['class' => 'needs-validation', 'novalidate' => 'novalidate'],
        ]);
    }
}
