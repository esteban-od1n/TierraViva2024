<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Admin\Field\VichImageField;
use App\Enum\UserRoles;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            "email",
            "password",
            VichImageField::new("profilePicture"),
            ChoiceField::new("roles")
                ->setFormTypeOption("multiple", true)
                ->setChoices(function (?User $currentUser) {
                    $cases = UserRoles::cases();
                    $choices = [];
                    foreach ($cases as $c) {
                        $choices[$c->name] = $c->value;
                    }
                    return $choices;
                }),
            "isVerified",
        ];
    }
}
