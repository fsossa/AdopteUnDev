<?php

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('avatar')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('my_notes', EntityType::class, [
                'class' => Developer::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('dev_give_notes', EntityType::class, [
                'class' => Developer::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}
