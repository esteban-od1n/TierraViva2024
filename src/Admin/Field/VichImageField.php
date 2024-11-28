<?php

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class VichImageField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $property, $label = null)
    {
        return (new self())
            ->setProperty($property)
            ->setLabel($label)
            ->setFormType(VichImageType::class);
    }
}
