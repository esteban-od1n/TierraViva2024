<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("body", TextareaType::class, [
                "label" => "Comentario",
            ])
            ->add("author", EntityType::class, [
                "class" => User::class,
                "choice_label" => "name",
                "label" => "Author",
                "required" => true,
            ])
            ->add("post", EntityType::class, [
                "class" => Post::class,
                "choice_label" => "title",
                "label" => "Post",
                "required" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Comment::class,
        ]);
    }
}