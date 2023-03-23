<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: '/subscribe')]
    public function index(Request $request , EntityManager $manager): Response
    {
        
        // $role = array("'roles' : 'ROLE_USER'");
        $user = new User();
        $user->setRoles([]);
        $form = $this->createForm(UserFormType::class,$user);

        //handleRequest va faire matcher les element la class user pour les ajouter
        $form->handleRequest($request);

        //si le formulaire est envoyer et valide
        if ($form->isSubmitted() && $form->isValid()) {
            dd($user);
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('/home');
        }

        return $this->render('subscribe/index.html.twig', [
            'form' => $form,
        ]);
    }

}
