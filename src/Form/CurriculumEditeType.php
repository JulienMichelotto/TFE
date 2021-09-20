<?php

namespace App\Form;

use App\Entity\Curiculum;
use App\Entity\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CurriculumEditeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,[
                'attr' => array(
                    'placeholder' => 'Titre du CV'
                )
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de profil',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
            ])
            ->add('template', EntityType::class,[
                'class' => Template::class,
                'choice_label' => 'descr',
            ])
             ->add('highlightColor', null,[
                'label' => 'Couleur de thème',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer les modifications',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Curiculum::class,
        ]);
    }
}
