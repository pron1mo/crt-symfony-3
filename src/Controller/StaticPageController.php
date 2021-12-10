<?php

namespace App\Controller;

use App\Entity\StaticPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPageController extends AbstractController
{
    #[Route('/static/{id}', name: 'static_page')]
    public function index(StaticPage $id): Response
    {
        return $this->render('static/index.html.twig', [
            'page' => $id,
        ]);
    }
}
