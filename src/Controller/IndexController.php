<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        EntityManagerInterface $entityManager,
        Session $session
    ): Response
    {
        if($session->has('user'))
        {
            $movies = $entityManager->getRepository(Movie::class)->findAll();
            $user = $entityManager->getRepository(User::class)->find($session->get('user')->getId());
            $admin = 0;

            if ($user->isAdmin()) {
                $admin = 1;
            }

            return $this->render('Page/index.html.twig', [
                'films' => $movies,
                'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('signin');
        }
    }

    #[Route('/signin', name: 'signin')]
    public function inscription(
        Request $request,
        EntityManagerInterface $entityManager,
        Session $session): Response
    {
        return $this->render('Page/signin.html.twig');
    }

    #[Route('/signout', name: 'signout')]
    public function connexion(
        Session $session
    ): Response
    {
        if($session->has('user'))
        {
            $session->remove('user');
        }

        return $this->redirectToRoute('signin');
    }

    #[Route('/new', name: 'add')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Session $session
    ): Response
    {
        if($session->has('user') && $session->get('user')->isAdmin())
        {
            return $this->render('Page/index.html.twig');
        }

        return $this->redirectToRoute('index');
    }

    #[Route('/watch/{id}', name: 'watch')]
    public function watch(
        EntityManagerInterface $entityManager,
        Session $session,
        int $id
    ): Response
    {
        if($session->has('user'))
        {
            $movie = $entityManager->getRepository(Movie::class)->find($id);

            return $this->render('Page/watch.html.twig', [
                'film' => $movie
            ]);
        } else {
            return $this->redirectToRoute('signin');
        }

    }
}