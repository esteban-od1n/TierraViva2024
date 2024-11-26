<?php

namespace App\Form;

use App\Entity\ForumPost;
use App\Entity\ForumTopics;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('post_date', null, [
                'widget' => 'single_text',
            ])
            ->add('body')
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('topics', EntityType::class, [
                'class' => ForumTopics::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('likes', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ForumPost::class,
        ]);
    }
}
