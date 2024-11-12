<?php

declare(strict_types=1);

namespace App\Controller;

use Cassandra\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/create', name: 'user_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $file->move('upload', uniqid() . '.' . $file->guessExtension());
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('');
        }
        return $this->render('user/create.html.twig', [
            'user' => $user
        ]);
    }
}
