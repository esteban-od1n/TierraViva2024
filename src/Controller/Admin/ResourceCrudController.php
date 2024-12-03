<?php

namespace App\Controller\Admin;

use App\Admin\Field\VichFileField;
use App\Entity\Resource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ResourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resource::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            "name",
            "date",
            "description",
            ChoiceField::new("type"),
            VichFileField::new("resourceFile"),
            "promote",
        ];
    }
}
