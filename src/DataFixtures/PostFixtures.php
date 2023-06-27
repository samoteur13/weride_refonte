<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Post;
use App\Entity\Trip;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $trips = $manager->getRepository(Trip::class)->findAll();
        $posts = [];
        
        
        
        foreach ($trips as $key => $trip) {
          $riders = $manager->getRepository(Trip::class)->findAllRiderThanid($trip->getId());
          foreach ($riders as $ridersKey => $rider) {
              $user = $manager->getRepository(User::class)->findOneBy(['id' => $rider['user_id'] ]);

              for ($i = 0; $i < rand(1, 4); $i++) {
                  $posts[$i] = new Post();
                  $posts[$i]->setContent($faker->text());
                  $posts[$i]->setTrip($trip);
                  $posts[$i]->setUser($user);
                  $manager->persist($posts[$i]);
              }
            }

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TripFixtures::class,
            UserFixtures::class
        ];
    }
}
