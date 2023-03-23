<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;



#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $posts = $entityManager->getRepository(Post::class)->findAll();
        $onPosts = $entityManager->getRepository(Post::class)->findOneBy(['id' => 236 ]);

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);
        $serializerObject = new Serializer([new ObjectNormalizer()]);

        //select les groupe //ou ignore
        $dataGroupe = $serializer->normalize($posts, null, ['groups' => ['string','object']]);

        //select les attributes
        $dataAttribute = $serializer->normalize($onPosts, null, [AbstractNormalizer::ATTRIBUTES => ['content', 'user_id' => ['email'] ] ]);
       


        // $jsonContent = $serializer->serialize( $data, 'json');
        // echo $jsonContent;
        return $this->json($dataAttribute);

     
    }

}
