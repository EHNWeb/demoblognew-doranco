<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/articles", name="admin_articles")
     */
    public function adminArticles(ArticleRepository $repo, EntityManagerInterface $manager)
    {
        // On utilise le manager pour récupérer le nom des champs de la table Article
        $chapmsTableArticles = $manager->getClassMetadata(Article::class)->getFieldNames();

        // dd($chapmsTableArticles); // dd() : dump & die : afficher des infos et arrêter l'exécution du code

        $articles = $repo->findAll();

        return $this->render("admin/admin_articles.html.twig", [
            'articles' => $articles,
            'champs' => $chapmsTableArticles
        ]);
    }

    /**
     * @Route("/admin/article/new", name="admin_new_article")
     * @Route("/admin/article/edit/{id}", name="admin_edit_article")
     */
    // La classe REQUEST contient les données véhiculées par les super globales ($_POST, $_GET, ...)
    public function article_form(Request $superGlobals, EntityManagerInterface $manager, Article $article = null)
    {
        // L'objet ARTICLE recevra les données du formulaire
        if (!$article) {
            $article = new Article();
            $article->setCreateAt(new \DateTime());
            $messageForm = "L'article a bien été crée !";
        } else {
            $messageForm = "L'article n° " . $article->getId() . " a bien été modifié !";
        }

        // CREATEFORM permet de récupérer un formulaire existant #}
        $form = $this->createForm(ArticleType::class, $article);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('success', $messageForm);
            return $this->redirectToRoute('admin_articles');
        }

        return $this->renderForm("admin/article_form.html.twig", [
            'formArticle' => $form,
            'editMode' => $article->getId() !== NULL
        ]);          
    }
}
