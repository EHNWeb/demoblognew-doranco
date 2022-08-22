<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Instanciation de faker avec la locale FR
        $faker = \Faker\Factory::create('fr-FR');

        // Creation de 3 categories
        for ($i = 1; $i <= 3; $i++) {
            // Creation de l'Objet
            $category = new Category;

            // Initialisation des données
            $category->setTitle($faker->sentence(3, false));

            // Creation requete Insertion en BDD
            $manager->persist($category);

            // Creation des articles entre 4 et 6
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                // Creation de l'Objet
                $article = new Article;

                // Initialisation des données
                $content = "<p>" . join("</p><p>", $faker->paragraphs(5)) . "</p>";
                $article->setTitle($faker->sentence(3, false))
                    ->setContent($content)
                    ->setImage($faker->imageUrl)
                    ->setCreateAt($faker->dateTimeBetween("-6 months"))
                    ->setCategory($category);

                //  Creation requete Insertion en BDD
                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(5, 10); $k++) {
                    // Creation de l'Objet
                    $comment = new Comment;

                    // Initialisation des données
                    $content = "<p>" . join("</p><p>", $faker->paragraphs(2)) . "</p>";
                    // Methodde 1
                    // $now = new \DateTime;
                    // $interval = $now->diff($article->getCreateAt());
                    // $days = $interval->days;

                    // Methode 2
                    $days = (new \DateTime())->diff($article->getCreateAt())->days;

                    $comment->setAuthor($faker->name)
                    ->setContent($content)
                    ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                    ->setArticle($article);

                    //  Creation requete Insertion en BDD
                    $manager->persist($comment);
                }
            }
        }

        // Execution de toutes les requetes $manager->persiste()
        $manager->flush();
    }
}