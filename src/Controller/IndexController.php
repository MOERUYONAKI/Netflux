<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
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
        if($session->has('user'))
        {
            $movies = $entityManager->getRepository(Movie::class)->findAll();
            $user = $entityManager->getRepository(User::class)->find($session->get('user')->getId());
            $admin = 0;

            if (in_array("ROLE_ADMIN",$user->getRoles())) {
                $admin = 1;
            }

            return $this->render('Page/index.html.twig', [
                'films' => $movies,
                'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('app_register');
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/new', name: 'add')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        Session $session,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/medias')] string $mediasFile
    ): Response
    {
        $user = $entityManager->getRepository(User::class)->find($session->get('user')->getId());

        if($session->has('user') && in_array("ROLE_ADMIN", $user->getRoles()))
        {
            $movie = new Movie();

            $form = $this->createForm(MovieType::class, $movie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $posterFile = $form->get('poster')->getData();
                $movieFile = $form->get('movie')->getData();

                if ($posterFile && $movieFile) {
                    $originalFilename = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilenamePoster = $slugger->slug($originalFilename);
                    $newFilenamePoster = $safeFilenamePoster . '-' . uniqid() . '.' . $posterFile->guessExtension();

                    $posterFile->move(
                        $mediasFile,
                        $newFilenamePoster
                    );

                    if ($movieFile->guessExtension() != 'mp4') {
                        throw new Exception('Invalid file type.');
                    }

                    $originalFilename = pathinfo($movieFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilenameMovie = $slugger->slug($originalFilename);
                    $newFilenameMovie = $safeFilenameMovie.'-'.uniqid().'.'.$movieFile->guessExtension();

                    $movieFile->move(
                        $mediasFile,
                        $newFilenameMovie
                    );

                    $movie->setImagePath($newFilenamePoster);
                    $movie->setPath($newFilenameMovie);
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