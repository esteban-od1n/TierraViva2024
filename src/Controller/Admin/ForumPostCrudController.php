<?php

namespace App\Controller\Admin;

use App\Entity\ForumPost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForumPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ForumPost::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Forum Posts")
            ->setPageTitle("detail", fn(ForumPost $post) => "\"{$post->getTitle()}\"")
            ->setPageTitle(
                "edit",
                fn(ForumPost $post) => sprintf("Editing <b>%s</b>", $post->getTitle())
            )
            ->setPageTitle("new", "New post");
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            "title",
            "post_date",
            "body",
            AssociationField::new("author"),
            AssociationField::new("topics"),
            "promote",
        ];
    }
}
