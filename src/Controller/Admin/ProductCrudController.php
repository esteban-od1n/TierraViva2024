<?php

namespace App\Controller\Admin;

use App\Admin\Field\VichImageField;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            "name",
            "description",
            "price",
            AssociationField::new("provider"),
            VichImageField::new("productImage"),
            "promote",
        ];
    }
}
