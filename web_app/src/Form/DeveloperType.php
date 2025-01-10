<?php

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('birthday', null, [
                'widget' => 'single_text',
            ])
            ->add('gender')
            ->add('experiences')
            ->add('salary')
            ->add('biography')
            ->add('location')
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (Image file)',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Image([
                        'maxSize' => '2M',
                    ]),
                    new \Symfony\Component\Validator\Constraints\File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Merci d\'ajouter un fichier image valide(jpeg, png, gif).',
                    ]),
                ],
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            // ->add('my_notes', EntityType::class, [
            //     'class' => Developer::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            // ->add('dev_give_notes', EntityType::class, [
            //     'class' => Developer::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}
