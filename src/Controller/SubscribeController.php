<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: '/subscribe')]
    public function index(Request $request ): Response
    {
        
        // $role = array("'roles' : 'ROLE_USER'");
        $user = new User();
        $user->setRoles([]);
        // dd($user);
        $form = $this->createForm(UserFormType::class,$user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }

        return $this->render('subscribe/index.html.twig', [
            'form' => $form,
        ]);
    }

}
