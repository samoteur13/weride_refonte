<?php

namespace App\DataFixtures;



use Faker;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {   
        $faker = Faker\Factory::create('fr_FR');

        $users = [];
        $posts = [];

            for ($i=0; $i < 5 ; $i++) { 
                $email = $faker->email;

                $users[$i] = new User();
                $users[$i]->setEmail($email);
                $users[$i]->setRoles([]);
                $users[$i]->setFirstname($faker->firstname);
                $users[$i]->setLastname($faker->lastName);
                $users[$i]->setPseudo($faker->userName);
                $users[$i]->setPassword($this->passwordHasher->hashPassword(
                    $users[$i],
                    $email
                ));


                $manager->persist($users[$i]);
            }
        $manager->flush();
    }
}
