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

            // Insertin en BDD
            $manager->persist($category);

            // Creation des articles entre 4 et 6
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                // Creation de l'Objet
                $article = new Article;

                // initialisation des données
                $content = "<p>" . join("</p><p>", $faker->paragraphs(5, true)) . "</p>";
                $article->setTitle($faker->sentence(3, false))
                    ->setContent($content)
                    ->setImage($faker->imageUrl)
                    ->setCreateAt($faker->dateTimeBetween("-6 months"))
                    ->setCategory($category);

                // Insertion en BDD
                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(5, 10); $k++) {
                    // Creation de l'Objet
                    $comment = new Comment;

                    // Initialisation des données
                    $content = "<p>" . join("</p><p>", $faker->paragraphs(2, true)) . "</p>";
                    $now = new \DateTime;
                    $interval = $now->diff($article->getCreateAt());

                }
            }
        }
    }
}
