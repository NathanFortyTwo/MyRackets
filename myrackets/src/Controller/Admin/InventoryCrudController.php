<?php

namespace App\Controller\Admin;

use App\Entity\Inventory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class InventoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Inventory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('description'),
            AssociationField::new('rackets')->setTemplatePath('admin/fields/inventory_racket.html.twig'),
            AssociationField::new('tennisMan'),


        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
