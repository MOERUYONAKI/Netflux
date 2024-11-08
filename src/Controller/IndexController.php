<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $testFilms = [
            [
                "title" => "Astérix et Obélix : L'Empire Du Milieu",
                "date" => "",
                "image" => "/medias/L'Empire Du Milieu.jpg",
                "movie" => ""
            ],
        ];

        return $this->render('Page/index.html.twig', [
            'films' => $testFilms
        ]);
    }

    #[Route('/incription', name: 'inscription')]
    public function inscription(): Response
    {
        return $this->render('Page/index.html.twig');
    }

    #[Route('/connexion', name: 'connexion')]
    public function connexion(): Response
    {
        return $this->render('Page/index.html.twig');
    }

    #[Route('/watch/{id}', name: 'watch')]
    public function watch(): Response
    {
        return $this->render('Page/index.html.twig');
    }
}