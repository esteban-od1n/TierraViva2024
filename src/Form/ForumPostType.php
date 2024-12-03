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
            ->add("title")
            ->add("body")
            ->add("author", EntityType::class, [
                "class" => User::class,
                "choice_label" => "email",
            ])
            ->add("topics", EntityType::class, [
                "class" => ForumTopics::class,
                "choice_label" => "name",
                "multiple" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => ForumPost::class,
        ]);
    }
}
