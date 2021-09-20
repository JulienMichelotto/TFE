<?php

namespace App\Form;

use App\Entity\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // $colors = '';
        $builder
            ->add('descr', ChoiceType::class, [
                'label' => 'Modèle',
                'choices'  => [
                    '---' => null,
                    'Base' => 'base',
                    'Deluxe italic' => "deluxe italique",
                ],
            ])
            ->add('dark', ChoiceType::class, [
                'label' => 'Fond',
                'choices'  => [
                    '---' => null,
                    'Sombre' => true,
                    'Claire' => false,
                ],
            ])
            ->add('active', ChoiceType::class, [
                'label' => 'Actif / Inactif',
                'choices'  => [
                    '---' => null,
                    'Actif' => true,
                    'Incactif' => false,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Template::class,
        ]);
    }
}
