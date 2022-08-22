<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
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
            $category = new Category;
            $category->setTitle($faker->sentence(3, false));
        }
    }
}