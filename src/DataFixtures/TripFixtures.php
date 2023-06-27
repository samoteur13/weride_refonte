<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Trip;
use App\Entity\User;
use App\Entity\TripSteps;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TripFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();
        $trips = [];


        $type = ['pepere', 'normal', 'plain gaz'];

        foreach ($users as $key => $user) {

            for ($i = 0; $i < rand(1, 3); $i++) {

                $trips[$i] = new Trip();
                $trips[$i]->setTitle($faker->name);
                $trips[$i]->setStartDate($faker->dateTime());
                $trips[$i]->setEndDate($faker->dateTime());
                $trips[$i]->setType($type[rand(0, 2)]);
                $trips[$i]->setDescription($faker->text());
                $trips[$i]->setUser($user);

                for ($i2 = 0; $i2 < rand(1, 4); $i2++) {
                    $trips[$i]->addRiderJoin($users[rand(0, (COUNT($users) - 1))]);
                }

                $manager->persist($trips[$i]);

                for ($i3=0; $i3 < rand(2,3) ; $i3++) { 
                    $trip_steps[$i3] = new TripSteps;
                    $trip_steps[$i3]->setCity($faker->city);
                    $trip_steps[$i3]->setAdditionalAdress($faker->streetAddress);
                    $trip_steps[$i3]->setLongitude(0.0);
                    $trip_steps[$i3]->setLatitude(0.0);
                    $trip_steps[$i3]->setTrip($trips[$i]);
                    $manager->persist($trip_steps[$i3]);
                }
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
