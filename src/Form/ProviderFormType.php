<?php

namespace App\Form;

use App\Entity\Providers;
use App\Enum\ProviderCategories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nombre",
                "required" => true,
            ])
            ->add("location", TextType::class, [
                "label" => "Direccion",
                "required" => true,
            ])
            ->add("category", EnumType::class, [
                "class" => ProviderCategories::class,
                "label" => "Categoria",
            ])
            ->add("visible", CheckboxType::class, [
                "label" => "Visible",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Providers::class,
        ]);
    }
}
