<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        EntityManagerInterface $entityManager
    ): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render('Page/index.html.twig', [
            'films' => $movies
        ]);
    }

    #[Route('/registration', name: 'registration')]
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
    public function watch(
        EntityManagerInterface $entityManager,
        int $id
    ): Response
    {
        $movie = $entityManager->getRepository(Movie::class)->find($id);

        return $this->render('Page/watch.html.twig', [
            'film' => $movie
        ]);
    }
}