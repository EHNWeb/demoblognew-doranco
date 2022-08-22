<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="app_blog")
     */
    // Pour récupérer le repository, je le passe en paramètre de la methode index
    // Cela s'appelle une injection de dépendance
    public function index(ArticleRepository $repo): Response
    {
        // Appel de la méthode FINDALL pour récupérer tous les éléments
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'tabArticles' => $articles
        ]);

        // Toutes les méthodes d'un controller renvoient un objetde type Response
        // render() permet d'afficher le contenu d'un template
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur le blog',
            'age' => 28
        ]);
    }
    // Le permier argument de render() est le fichier à afficher
    // le 2ème argument est un tableau associatif

    /**
     * @Route("/blog/show/{id}", name="blog_show")
     */
    public function show($id, ArticleRepository $repo, Request $superGlobals, EntityManagerInterface $manager): Response
    {
        // Appel de la méthode FIND pour récupérer l'éléments ID
        $article = $repo->find($id);

        $commentaire = new Comment();
        $commentaire->setArticle($article);
        //$commentaire->setAuthor($user->getId());
        $commentaire->setCreatedAt(new \DateTime());
        $messageForm = "Le commentaire a été ajouté !";

        // CREATEFORM permet de récupérer un formulaire existant #}
        $form = $this->createForm(CommentType::class, $commentaire);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($commentaire);
            $manager->flush();
            $this->addFlash('success', $messageForm);
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('blog/show.html.twig', [
            'formComment' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/edit/{id}", name="blog_edit")
     */
    // La classe REQUEST contient les données véhiculées par les super globales ($_POST, $_GET, ...)
    public function form(Request $superGlobals, EntityManagerInterface $manager, Article $article = null)
    {
        // L'objet ARTICLE recevra les données du formulaire
        if (!$article) {
            $article = new Article();
            $article->setCreateAt(new \DateTime());
            $messageForm = "L'article a bien été crée !";
        } else {
            $messageForm = "L'article n° ".$article->getId()." a bien été modifié !";
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
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->renderForm("blog/form.html.twig", [
            'formArticle' => $form,
            'editMode' => $article->getId() !== NULL
        ]);

        // 2nd méthode d'envoyer un formulaire à un template

        // return $this-.render('blog/form.html.twig', [
        //     'formArticle' => $form->createView()
        // });           
    }

    /**
     * @Route("/blog/delete/{id}", name="blog_delete")
     */
    public function delete(EntityManagerInterface $manager, $id, ArticleRepository $repo)
    {
        $article = $repo->find($id);

        // remove() prepare la suppression d'un article
        $manager->remove($article);

        // Execution de la requete preparée
        $manager->flush();

        // addFlash() permet de créer un message de notification
        // Le 1er argument est le type du message que l'on veut
        // Le 2nd argument est le message
        $this->addFlash('success', "L'article n° $id a bien été supprimé !");

        return $this->redirectToRoute('app_blog');
    }
}
