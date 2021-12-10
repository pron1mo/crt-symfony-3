<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'homepage', defaults: ['page' => 1])]
    #[Route('/page/{page}', name: 'article_page', defaults: ['page' => 1])]
    public function index(EntityManagerInterface $em, $page): Response
    {
        $postRepo = $em->getRepository(Article::class);
        $limit = 5;
        $posts = $postRepo->countPages($page, $limit);
        $navigator = [
            'page' => $page,
            'pages' => ceil(($postRepo->countTotal() / $limit)),
            'total' => $postRepo->countTotal(),
            'limit' => $limit,
        ];
        return $this->render('index/index.html.twig', [
            'articles' => $posts,
            'navigator' => $navigator
        ]);
    }
}
