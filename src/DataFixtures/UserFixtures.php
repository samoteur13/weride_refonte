<?php

namespace App\DataFixtures;



use Faker;
use App\Entity\Bike;
use App\Entity\Post;
use App\Entity\Trip;
use App\Entity\TripSteps;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = Faker\Factory::create('fr_FR');

        $users = [];
        $bikes = [];
        $trips = [];
        $posts = [];
        $trip_steps = [];


        $mark_bikes = ['Yamaha', 'Honda', 'Suziki', 'Ninja'];
        $type = ['pepere','normal','plain gaz'];
            for ($i=0; $i < 5 ; $i++) { 
                $users[$i] = new User();
                $users[$i]->setEmail($faker->email);
                $users[$i]->setRoles([]);
                $users[$i]->setFirstname($faker->firstname);
                $users[$i]->setLastname($faker->lastName);
                $users[$i]->setPseudo($faker->userName);
                $users[$i]->setPassword($faker->password);

                for ($i1=0; $i1 < rand(1, 2) ; $i1++) { 
                    $bikes[$i1] = new Bike();
                    $bikes[$i1]->setName($mark_bikes[rand(0,3)]);
                    $bikes[$i1]->setPower(rand(500,1000));
                    $bikes[$i1]->setUser($users[$i]);

                    $manager->persist($bikes[$i1]);
                }

                for ($i2=0; $i2 < rand(1,2) ; $i2++) { 
                    $date = new \DateTime;
                    $trips[$i2] = new Trip() ;
                    $trips[$i2]->setTitle($faker->name) ;
                    $trips[$i2]->setStartDate($faker->dateTime()) ;
                    $trips[$i2]->setEndDate($faker->dateTime()) ;
                    $trips[$i2]->setType($type[rand(0,2)]);
                    $trips[$i2]->setDescription( $faker->text()) ;
                    $trips[$i2]->setUser($users[$i]) ;

                    for ($i3=0; $i3 < rand(1,4) ; $i3++) { 
                        $trips[$i2]->addRiderJoin($users[$i]) ;
                    }

                    $manager->persist( $trips[$i2]);
                    
                    for ($i4=0; $i4 < rand(1,4) ; $i4++) { 
                       $posts[$i4] = new Post();
                       $posts[$i4]->setContent( $faker->text());
                       $posts[$i4]->setTripId($trips[$i2]);
                       $posts[$i4]->setUserId($users[$i]);
                       $manager->persist($posts[$i4]);
                    }

                    for ($i5=0; $i5 < rand(2,3) ; $i5++) { 
                        $trip_steps[$i5] = new TripSteps;
                        $trip_steps[$i5]->setCity($faker->city);
                        $trip_steps[$i5]->setAdditionalAdress($faker->streetAddress);
                        $trip_steps[$i5]->setLongitude(0.0);
                        $trip_steps[$i5]->setLatitude(0.0);
                        $trip_steps[$i5]->setTrip($trips[$i2]);
                        $manager->persist($trip_steps[$i5]);
                    }

                }


                $manager->persist($users[$i]);
            }
        $manager->flush();
    }
}
