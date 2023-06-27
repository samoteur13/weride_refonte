<?php

namespace App\DataFixtures;

use App\Entity\Bike;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BikeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $bikes = [];
        $mark_bikes = ['Yamaha', 'Honda', 'Suziki', 'Ninja'];

        
        foreach ($users as $key => $user) {

            for ($i=0; $i < rand(1,3) ; $i++) { 
               
                $bikes[$i] = new Bike();
                $bikes[$i]->setName($mark_bikes[rand(0,3)]);
                $bikes[$i]->setPower(rand(500,1000));
                $bikes[$i]->setImgBike('https://cdn4.louis.de/r/4f02f576d96ee911b5de0d1f9d4f07b747efb28f/de-bspecial-ktm-125-duke-img-00-1200x752.jpg');
                $bikes[$i]->setUser($user);
                $manager->persist($bikes[$i]);
            }

        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
