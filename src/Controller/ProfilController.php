<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(CommentRepository $repo): Response
    {

        $user = $this->getUser();

        // Appel de la méthode FINDBY pour récupérer tous les éléments
        // Condition: WHERE author = $user
        $commentaires = $repo->findBy(["author" => $user]);

        return $this->render('profil/index.html.twig', [
            'tabCommentaires' => $commentaires
        ]);
    }
}
