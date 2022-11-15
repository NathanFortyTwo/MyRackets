<?php

namespace App\Controller\Admin;

use App\Entity\Racket;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Inventory;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class RacketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Racket::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextEditorField::new('description'),
            AssociationField::new('Category') // remplacer par le nom de l'attribut spécifique, par exemple 'bodyShape'
                ->onlyOnDetail()
                ->formatValue(function ($value, $entity) {
                    return implode(', ', $entity->getCategory()->toArray()); // ici getBodyShapes()
                })

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
