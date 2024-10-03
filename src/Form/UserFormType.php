<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nombre",
            ])
            ->add("email", EmailType::class, [
                "label" => "Correo",
            ])
            ->add("plainPassword", PasswordType::class, [
                "required" => false,
                "mapped" => false,
                "attr" => ["autocomplete" => "new-password"],
                "label" => "Contraseña",
            ])
            ->add("avatarImage", FileType::class, [
                "required" => false,
                "mapped" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "2024k",
                        "mimeTypes" => ["image/png", "image/jpeg", "image/webp"],
                        "mimeTypesMessage" => "Please upload a valid PDF document",
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
        ]);
    }
}
