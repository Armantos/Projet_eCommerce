<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('content'),
            IdField::new('prix')->hideOnForm(),
            IdField::new('stock')->hideOnForm(),
            ImageField::new('image')->setUploadDir("public/assets/eCommerce/images")
                ->setBasePath("assets/eCommerce/images")
                ->setRequired(false), //empeche d'ajouter une deuxieme image
            AssociationField::new('author'),
            AssociationField::new('category'),
        ];
    }

}
