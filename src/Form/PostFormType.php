<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'label' => 'Author',
                'required' => true,
            ])
        //    ->add('date', DateType::class, [
         //       'widget' => 'single_text',
        //        'label' => 'Publication Date',
        //        'required' => true,
         //   ])
            ->add('body', TextareaType::class, [
                'label' => 'Content',
                'required' => false,
            ])
            ->add('topic', EntityType::class, [
                'class' => Topic::class,
                'choice_label' => 'name',
                'label' => 'Topics',
                'multiple' => true,
                'expanded' => false, // Select múltiple
                'required' => false,
            ]);
    //        ->add('likes', EntityType::class, [
    //            'class' => User::class,
    //            'choice_label' => 'name',
    //            'label' => 'Likes',
    //            'multiple' => true,
     //           'expanded' => false, // Select múltiple
     //           'required' => false,
    //        ]);
      }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
