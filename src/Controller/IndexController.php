<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\String\Slugger\SluggerInterface;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        EntityManagerInterface $entityManager,
        Session $session
    ): Response
    {
//        if($session->has('user'))
//        {
//            $movies = $entityManager->getRepository(Movie::class)->findAll();
//            $user = $entityManager->getRepository(User::class)->find($session->get('user')->getId());
//            $admin = 0;
//
//            if ($user->isAdmin()) {
//                $admin = 1;
//            }
//
//            return $this->render('Page/index.html.twig', [
//                'films' => $movies,
//                'admin' => $admin
//            ]);
//        } else {
//            return $this->redirectToRoute('app_register');
//        }

        $movies = $entityManager->getRepository(Movie::class)->findAll();
        $admin = 0;

        return $this->render('Page/index.html.twig', [
            'films' => $movies,
            'admin' => $admin
        ]);
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

        return $this->redirectToRoute('app_register');
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'add')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Session $session,
        SluggerInterface $slugger
    ): Response
    {
        if($session->has('user') && $session->get('user')->isAdmin())
        {
            $movie = new Movie();

            $form = $this->createForm(MovieType::class, $movie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $posterFile = $form->get('poster')->getData();
                $movieFile = $form->get('movie')->getData();

                if ($posterFile) {
                    $originalFilename = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $posterFile->guessExtension();

                    $posterFile->move(
                        $this->getParameter('medias_directory'),
                        $newFilename
                    );

                    $movie->setImagePath($newFilename);
                }

                if ($movieFile) {
                    if (!in_array($movieFile->guessExtension(), ['mp4'])) {
                        throw new Exception('Invalid file type.');
                    }

                    $originalFilename = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$posterFile->guessExtension();

                    $posterFile->move(
                        $this->getParameter('medias_directory'),
                        $newFilename
                    );

                    $movie->setPath($newFilename);
                }

                $entityManager->persist($movie);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }

            return $this->render('Page/create.html.twig', [
                'form' => $form->createView(),
            ]);
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
            return $this->redirectToRoute('app_register');
        }
    }
}