<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserModificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
//                'attr' => [
//                    'placeholder' => 'Prénom'
//                ],
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Nom',
//                'attr' => [
//                    'placeholder' => 'Prénom'
//                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Mr' => 'mr',
                    'Mme' => 'mme',
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone (fixe)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'ex:0499 99 99 99 ou +32 499 99 99 99'
               ],
            ])
            ->add('gsmNumber', TextType::class, [
                'label' => 'Numéro GSM',
               'attr' => [
                   'placeholder' => 'ex:0499 99 99 99 ou +32 499 99 99 99'
               ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
            //    'attr' => [
            //        'placeholder' => 'ex:0499 99 99 99 ou +32 499 99 99 99'
            //    ],
            ])
            ->add('streetNumber',null,[
                'label' => 'Numéro de rue',
            ])
            ->add('boxNumber', TextType::class, [
                'label' => 'Numéro de boite',
                'required' => false,
            //    'attr' => [
            //        'placeholder' => 'ex:0499 99 99 99 ou +32 499 99 99 99'
            //    ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
//                'attr' => [
//                    'placeholder' => 'Prénom'
//                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
