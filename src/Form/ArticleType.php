<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Objet $builder permet de construire (créer) un formulaire
        // la méthode add() permet d'ajouter un champ au formulaire
        $builder
            ->add('title')
            ->add('content')
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('category', EntityType::class, [    // On indique que le champ CATEGORY est une entité
                'class' => Category::class,           // On indique que l'entité est CATEGORY
                'choice_label' => 'title'             // On indique que je veux afficher les titres des categories
            ])
            // Nous commentons le champs createDate car la date sera ajouter automatiquement lors de l'insertion en BDD
            // ->add('createAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
