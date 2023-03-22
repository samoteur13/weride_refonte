<?php

namespace App\DataFixtures;



use Faker\Factory;
use App\Entity\Bike;
use App\Entity\Trip;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = Factory::create('fr_FR');
        $users = [];
        $bikes = [];
        // $trips = [];

        $mark_bikes = ['Yamaha', 'Honda', 'Suziki', 'Ninja'];
            for ($i=0; $i < 5 ; $i++) { 
              
                $users[$i] = new User();
                $users[$i]->setEmail($faker->email);
                $users[$i]->setRoles([]);
                $users[$i]->setFirstname($faker->firstname);
                $users[$i]->setLastname($faker->lastName);
                $users[$i]->setPseudo($faker->tld );
                $users[$i]->setPassword($faker->password);

                for ($i1=0; $i1 < rand(1, 2) ; $i1++) { 
                    $bikes[$i1] = new Bike();
                    $bikes[$i1]->setName($mark_bikes[rand(0,3)]);
                    $bikes[$i1]->setPower(rand(500,1000));
                    $bikes[$i1]->setUser($users[$i]);

                    $manager->persist($bikes[$i1]);
                }

                // for ($i2=0; $i2 < rand(0,2) ; $i2++) { 
                //     // $maintenant = new DateTime();
                //     $trips[$i2] = new Trip() ;
                //     $trips[$i2]->setTitle($faker->title) ;
                //     $trips[$i2]->setStartDate($maintenant) ;
                //     $trips[$i2]->setEndDate($maintenant) ;
                //     $trips[$i2]->setDescription($faker->sentence($nbWords = rand(10,20), $variableNbWords = true) ) ;
                //     $trips[$i2]->setDescription($users[$i]) ;
                // }

                $manager->persist($users[$i]);
            }
        $manager->flush();
    }
}
