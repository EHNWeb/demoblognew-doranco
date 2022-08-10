<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 10; $i++) {
            // On instancie la classe ARTICLE qui se trouve dans le dossier App/Entity
            $article = new Article;

            // On pourra ensuite faire appel au SETTERS pour insérer les données
            $article->setTitle("Titre de l'article n°$i")
                ->setContent("<p>Contenu de l'article n°$i</p>")
                ->setImage("http://picsum.photos/250/150")
                ->setCreateAt(new \DateTime());
            
            // Insertion des données
            // persist() permet de faire persister l'article dans le temps et préparer son insertion en BDD
            $manager->persist($article);
        }

        $manager->flush();
    }
}
