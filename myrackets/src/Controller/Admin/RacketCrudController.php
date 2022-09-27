<?php

namespace App\Controller\Admin;

use App\Entity\Racket;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RacketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Racket::class;
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
