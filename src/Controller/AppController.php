<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        // dd($users);
        return $this->render('app/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/profil/{id}', name: 'profil')]
    public function profil(EntityManagerInterface $entityManager, $id): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id ]);

        return $this->render('app/profil.html.twig', [
            'user' => $user
        ]);
    }

}
