<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/article/{id}', name: 'article')]
    public function showArticle(Article $id, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setArticle($id);
            $comment->setCreatedAt(new \DateTimeImmutable('now'));

            $em->persist($comment);
            $em->flush();

            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment);
        }

        return $this->render('article/index.html.twig', [
            'article' => $id,
            'form' => $form->createView()
        ]);
    }

}
