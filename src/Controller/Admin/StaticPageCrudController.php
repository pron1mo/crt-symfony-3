<?php

namespace App\Controller\Admin;

use App\Entity\StaticPage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StaticPageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StaticPage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Static Pages')
            ->setEntityLabelInSingular('Static Page')
            ->setDateFormat('short')
            ->setEntityPermission('ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content'),
            BooleanField::new('isInNavigation')
        ];
    }

}
