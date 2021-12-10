<?php

namespace App\Controller;

use App\Repository\StaticPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HeaderController extends AbstractController
{
    public function showHeader(StaticPageRepository $staticPageRepository)
    {
        $links = $staticPageRepository->findBy(['isInNavigation' => true]);
        return $this->render('components/header.html.twig', [
           'links' => $links
        ]);
    }

}
