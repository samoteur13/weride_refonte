<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

class AppUtilisateurController extends AbstractController
{

    #[Route('/api/profil', methods: ['GET'])]
    public function userProfil(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => ['userProfil']]);
    }

    #[Route('/api/userInfos', methods: ['GET'])]
    public function userAllInfos(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => ['user']]);
    }
}
