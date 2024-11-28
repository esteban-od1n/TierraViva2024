<?php

namespace App\Admin\Field;

use App\Form\PositionType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class MapField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFormType(PositionType::class)
            ->setLabel($label)
            ->setProperty($propertyName);
    }
}
