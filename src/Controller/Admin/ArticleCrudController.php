<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            // nNous ajoutons les champs du formulaire à affichier
            TextField::new('title', 'Titre'),
            ImageField::new('image')
                ->setBasePath('images/articles/')
                ->setUploadDir('public/images/articles')
                ->setRequired(false)
                ->setUploadedFileNamePattern('[ulid].[extension]'),
            TextareaField::new('content', 'Description')->renderAsHtml()->hideOnForm(),
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            DateTimeField::new('createAt', "Date d'ajout")->setFormat("d/M/Y à H:m:s"),
            AssociationField::new('category', 'Catégorie'),
            DateTimeField::new('updatedAt', 'Date de MAJ')->onlyOnForms(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        // La fonction sera exécuter lors de la creation d'un article avant ADD Article
        $article = new Article();
        $article->setCreateAt(new \DateTime);
        $article->setUpdatedAt(new \DateTime);
        $ifile = $article->getImageFile();
        if(!$ifile)
        {
            $article->setImage('default.png');
        }
        return $article;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // La fonction sera exécuter lors de la creation d'un article avant ADD Article
        $ifile = $entityInstance->getImage();

        if(!$ifile)
        {
            $entityInstance->setImage('default.png');
        }
        $entityInstance->setUpdatedAt(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }    

}
