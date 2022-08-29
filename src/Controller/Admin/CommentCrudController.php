<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('content', 'Description')->renderAsHtml()->onlyOnIndex(),
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            DateTimeField::new('createdAt', "Dated'ajout")->setFormat("d/M/Y à H:m:s"),
            AssociationField::new('article'),
            AssociationField::new('author', 'Auteur'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTime);

        return $comment;
    }
}
