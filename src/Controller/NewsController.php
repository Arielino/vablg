<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news')]
    public function index(ArticleRepository $articleRepo, Request $request, EntityManagerInterface $em): Response
    {
        $articles = $articleRepo->findAll();

        $commentForms = [];

        foreach ($articles as $article) {
            $commentaire = new Commentaire();
            $commentaire->setArticle($article);

            $form = $this->createForm(CommentaireType::class, $commentaire);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($commentaire);
                $em->flush();
                return $this->redirectToRoute('app_news');
            }

            $commentForms[$article->getId()] = $form->createView();
        }

        return $this->render('news/index.html.twig', [
            'articles' => $articles,
            'commentForms' => $commentForms,
        ]);
    }
}
