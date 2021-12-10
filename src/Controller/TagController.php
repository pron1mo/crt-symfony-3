<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{

    #[Route('/tag/{id}', name: 'tag')]
    public function showTag(Tag $id): Response
    {
        return $this->render('index/index.html.twig', [
            'articles' => $id->getArticles()
        ]);
    }

}
