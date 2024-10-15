<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\EquipmentItem;
use App\Entity\EquipmentType;
use App\Entity\Location;
use App\Enum\EquipmentState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Crée une instance de Faker avec les paramètres régionaux français

        // //Création des types d'équipements
        // for ($i = 0; $i < 10; $i++) {
        //     $location = new Location();
        //     $location
        //         ->setAisle($faker->numberBetween(0, 100));
        //     $manager->persist($location);
        // }

        // //Création des items d'équipements
        // for ($i = 0; $i < 100; $i++) {
        //     $equipmentItem = new EquipmentItem();
        //     $equipmentItem
        //         ->setName($faker->name)
        //         ->setEquipmentType($faker->randomElement(EquipmentType::class))
        //         ->setLoaned(false)
        //         ->setLocation($faker->randomElement(Location::class))
        //         ->setStatus($faker->randomElement(EquipmentState::cases()));
        //     $manager->persist($equipmentItem);
        // }

        // $manager->flush();
    }
}

