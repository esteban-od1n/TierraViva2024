<?php

namespace App\Controller\Admin;

use App\Entity\ForumComment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForumCommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ForumComment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return ["body", AssociationField::new("post"), AssociationField::new("author")];
    }
}