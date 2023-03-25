<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Post;
use App\Entity\Trip;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $trips = $manager->getRepository(Trip::class)->findAll();
        $posts = [];

        // for ($i = 0; $i < rand(1, 4); $i++) {
        //     $posts[$i] = new Post();
        //     $posts[$i]->setContent($faker->text());
        //     $posts[$i]->setTrip($trip);
        //     $posts[$i]->setUser($users[$i]);
        //     $manager->persist($posts[$i]);
        // }

        // dd(COUNT($trips));
        foreach ($trips as $key => $trip) {
          dd($trip->rider_join);
        }

        $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         TripFixtures::class,
    //     ];
    // }
}
