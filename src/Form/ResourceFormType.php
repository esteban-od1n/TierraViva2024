<?php

namespace App\Form;

use App\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ResourceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nombre",
            ])
            ->add("description", TextareaType::class, [
                "label" => "Descripcion",
            ])
            ->add("visible", CheckboxType::class, [
                "label" => "Visible",
            ])
            ->add("resourceFile", FileType::class, [
                "required" => false,
                "mapped" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" => [
                            "image/png",
                            "image/jpeg",
                            "image/webp",
                            "video/webm",
                            "video/mp4",
                            "video/3gpp",
                            "video/x-msvideo",
                            "video/quicktime",
                            "video/MP2T",
                            "application/pdf",
                        ],
                        "mimeTypesMessage" => "Please upload a valid PDF document",
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Resource::class,
        ]);
    }
}
