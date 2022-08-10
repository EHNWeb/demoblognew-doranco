<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Objet $builder permet de construire (créer) un formulaire
        // la méthode add() permet d'ajouter un champ au formulaire
        $builder
            ->add('title')
            ->add('content')
            ->add('image')
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
