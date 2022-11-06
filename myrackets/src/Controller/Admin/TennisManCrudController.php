<?php

namespace App\Controller\Admin;

use App\Entity\TennisMan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TennisManCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TennisMan::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
