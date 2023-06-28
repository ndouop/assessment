<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CarCategory;
use App\Entity\Car;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*
         * change parameter to create a certain quantity of car
         */
        $maxCarCategory = 16;
        $minCarPerCategory = 2;
        $maxCarPerCategory = 20;

        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));

        $baseColor = '0123456789ABCDEF';


        for($i = 0; $i < $maxCarCategory; $i++){
            $carCategory = new CarCategory();
            $carCategory->setName($faker->vehicleBrand);
            $manager->persist($carCategory);
            $numberOfCar = rand($minCarPerCategory, $maxCarPerCategory);
            for($j = 0; $j < $numberOfCar; $j++){
                $car = new Car();
                $car->setCategory($carCategory); // add category to car
                $car->setNbDoors($faker->vehicleDoorCount);
                $car->setNbSeats($faker->vehicleSeatCount);
                $car->setName($faker->vehicle);
                $car->setCost(mt_rand(1200, 250000));
                $color = '#'.substr(str_shuffle($baseColor), 0, 6); // generate random color
                $car->setColor($color);
                $manager->persist($car); // save car
            }
        }

        $manager->flush();
    }
}
