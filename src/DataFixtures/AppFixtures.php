<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\EquipmentItem;
use App\Entity\EquipmentType;
use App\Entity\Location;
use App\Entity\Stock;
use App\Entity\User;
use App\Enum\EquipmentState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Crée une instance de Faker avec les paramètres régionaux français

        // Création des catégories
        $categories = [
            'Selles',
            'Bridons et Equipement de Tête',
            'Accessoires',
            'Equipement de Soins',
            'Equipement de Transport',
            'Selles et Harnachements',
            'Vetements de Cavalier',
            'Accessoires de Sécurité',
            'Alimentation et Compléments',
            'Selles et Equipement Spécialisé'
        ];

        $categoryEntities = [];
        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categoryEntities[] = $category;
        }

        $manager->flush();

        // Création des emplacements (locations)
        $locationEntities = [];
        foreach ($categoryEntities as $category) {
            for ($i = 0; $i < mt_rand(3,10); $i++) {
                $location = new Location();
                $location->setAisle($category->getName());
                $location->setShelf($i);
                $manager->persist($location);
                $locationEntities[] = $location;
            }
        }
        
        $manager->flush();

        //Création des types d'équipements
        $types = [
            "Selles de Dressage",
            "Selles de Saut",
            "Selles Western",
            "Selles de Randonnée",
            "Bridons",
            "Mors",
            "Rênes",
            "Frontalières",
            "Étriers",
            "Sangles",
            "Tapis de Selle",
            "Protège-selles",
            "Produits de Toilettage",
            "Brosses",
            "Démêlants",
            "Garnitures de Secours",
            "Bandes de Transport",
            "Couvertures de Transport",
            "Filets de Transport",
            "Harnachements Complet",
            "Systèmes de Charge",
            "Systèmes de Harnais",
            "Vêtements de Compétition",
            "Gants de Cheval",
            "Chapeaux et Casques",
            "Bottes de Cheval",
            "Protecteurs de Chevaux",
            "Bandes de Protection",
            "Gilets de Sécurité",
            "Alimentation Équilibrée",
            "Suppléments Nutritionnels",
            "Produits de Hydratation",
            "Selles de Polo",
            "Selles de Voltige",
            "Selles de Course"];

        foreach ($types as $type) {
            for ($i = 0; $i < mt_rand(1,3); $i++) {

                //Création du stock pour ce type d'équipement
                $stock = new Stock();
                $stock
                    ->setQuantity($faker->numberBetween(1, 100))
                    ->setMinimumStockLevel($faker->numberBetween(1, 10));
                $manager->persist($stock);

                $equipmentType = new EquipmentType();
                $equipmentType
                    ->setName($type)
                    ->setDescription($faker->paragraph)
                    ->setCategory($faker->randomElement($categoryEntities))
                    ->setUnitPrice($faker->numberBetween(1, 100))
                    ->setBrand('Marque ' . ($i + 1))
                    ->setStock($stock);
                
                $manager->persist($equipmentType);
            }
        }
        $manager->flush();

        //Création des items d'équipements
        $equipmentTypes = $manager->getRepository(EquipmentType::class)->findAll();

        for ($i = 0; $i < count($equipmentTypes); $i++) {
            $stock = $equipmentTypes[$i]->getStock();
            $quantity = $stock->getQuantity();
            for ($j = 0; $j < $quantity; $j++) {
                $equipmentItem = new EquipmentItem();
                $equipmentItem
                    ->setEquipmentType($faker->randomElement($equipmentTypes))
                    ->setLocation($faker->randomElement($locationEntities))
                    ->setStatus($this->getWeightedRandomStatus());
                $manager->persist($equipmentItem);
            }
        }

        // Création des utilisateurs
        // Ajout d'un utilisateur ADMIN prédéfini
        $adminUser = new User();
        $adminUser
            ->setName('admin')
            ->setEmail('admin@admin.com')
            ->setPassword('admin')
            ->setRole('ADMIN');
        $manager->persist($adminUser);

        // Ajout d'un utilisateur USER prédéfini
        $regularUser = new User();
        $regularUser
            ->setName('user')
            ->setEmail('user@user.com')
            ->setPassword('user')
            ->setRole('USER');
        $manager->persist($regularUser);

        // Création des utilisateurs aléatoires
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setName($faker->name)
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setRole($faker->randomElement(['ADMIN', 'USER']));
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getWeightedRandomStatus(): EquipmentState
    {
        $random = mt_rand(1, 100);
        if ($random <= 70) {
            return EquipmentState::NEUF;
        } elseif ($random <= 80) {
            return EquipmentState::BON_ETAT;
        } elseif ($random <= 90) {
            return EquipmentState::USE;
        } elseif ($random <= 95) {
            return EquipmentState::EN_REPARATION;
        } else {
            return EquipmentState::HORS_SERVICE;
        }
    }
}
