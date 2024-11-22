<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\EquipmentItem;
use App\Entity\EquipmentType;
use App\Entity\Loan;
use App\Entity\Location;
use App\Entity\Movement;
use App\Entity\Notification;
use App\Entity\Repair;
use App\Entity\Stock;
use App\Entity\User;
use App\Enum\EquipmentState;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateInterval;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

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
            "Selle de Dressage",
            "Selle de Saut",
            "Selle Western",
            "Selle de Randonnée",
            "Bridon",
            "Mors",
            "Rêne",
            "Frontalière",
            "Étrier",
            "Sangle",
            "Tapis de Selle",
            "Protège-selle",
            "Produit de Toilettage",
            "Brosse",
            "Démêlant",
            "Garniture de Secours",
            "Bande de Transport",
            "Couverture de Transport",
            "Filet de Transport",
            "Harnachement Complet",
            "Système de Charge",
            "Système de Harnais",
            "Vêtement de Compétition",
            "Gant de Cheval",
            "Chapeau et Casque",
            "Botte de Cheval",
            "Protecteur de Cheval",
            "Bande de Protection",
            "Gilet de Sécurité",
            "Alimentation Équilibrée",
            "Supplément Nutritionnel",
            "Produit de Hydratation",
            "Selle de Polo",
            "Selle de Voltige",
            "Selle de Course"
        ];
        

        $marques = [
            "Cuir et Crinière",
            "Harnache & Co",
            "Équilibri'Art",
            "Galop Noble",
            "Cavalina",
            "Artisan Cavalier",
            "Dressage d'Or",
            "ÉquiSens",
            "Sellier du Vent",
            "Prestige Équestre"
        ];


        foreach ($types as $type) {
            for ($i = 0; $i < mt_rand(1,8); $i++) {

                //Création du stock pour ce type d'équipement
                $stock = new Stock();
                $stock
                    ->setQuantity($faker->numberBetween(1, 10))
                    ->setMinimumStockLevel($faker->numberBetween(1, 10));
                $manager->persist($stock);

                $equipmentType = new EquipmentType();
                $equipmentType
                    ->setName($type)
                    ->setDescription($faker->paragraph)
                    ->setCategory($faker->randomElement($categoryEntities))
                    ->setUnitPrice($faker->numberBetween(1, 100))
                    ->setBrand($faker->randomElement($marques))
                    ->setStock($stock);
                
                $manager->persist($equipmentType);
            }
        }
        $manager->flush();

        //Création des items d'équipements
        $equipmentTypes = $manager->getRepository(EquipmentType::class)->findAll();

        $equipmentItems = [];
        for ($i = 0; $i < count($equipmentTypes); $i++) {
            $stock = $equipmentTypes[$i]->getStock();
            $quantity = $stock->getQuantity();
            for ($j = 0; $j < $quantity; $j++) {
                $equipmentItem = new EquipmentItem();
                $equipmentItem
                    ->setEquipmentType($faker->randomElement($equipmentTypes))
                    ->setLocation($faker->randomElement($locationEntities))
                    ->setState($this->getWeightedRandomStatus());
                $manager->persist($equipmentItem);
                $equipmentItems[] = $equipmentItem;
            }
        }
        $manager->flush();

        // Création des utilisateurs
        // Ajout d'un utilisateur ADMIN prédéfini
        $adminUser = new User();
        $adminUser
            ->setName('admin')
            ->setEmail('admin@admin.com')
            ->setPassword($this->userPasswordHasher->hashPassword($adminUser, 'admin'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);

        // Ajout d'un utilisateur USER prédéfini
        $regularUser = new User();
        $regularUser
            ->setName('user')
            ->setEmail('user@user.com')
            ->setPassword($this->userPasswordHasher->hashPassword($adminUser, 'user'))
            ->setRoles(['ROLE_USER']);
        $manager->persist($regularUser);

        // Création des utilisateurs aléatoires
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setName($faker->name)
                ->setEmail($faker->email)
                ->setPassword($this->userPasswordHasher->hashPassword($user, $faker->password))
                ->setRoles([$faker->randomElement(['ROLE_ADMIN', 'ROLE_USER'])]);
            $manager->persist($user);

            if (in_array('ROLE_USER', $user->getRoles(), true)) {
                $users[] = $user;
            }
        }

        $manager->flush();

        //Création des emprunts (loan)
        foreach ($equipmentItems as $equipmentItem) {
            if ($equipmentItem->getState() === EquipmentState::EN_LOCATION) {
                $loan = new Loan();
                $loan
                    ->setEquipmentItem($equipmentItem)
                    ->setUser($faker->randomElement($users))
                    ->setDateLoaned($faker->dateTimeBetween('-3 month', 'now'))
                    ->setDateDue($faker->dateTimeBetween('-1 week', '+1 month'));
                $manager->persist($loan);
            }
        }


        //Création des réparations (repair)
        foreach ($equipmentItems as $equipmentItem) {
            if ($equipmentItem->getState() === EquipmentState::EN_REPARATION) {
                $repair = new Repair();
                $repair
                    ->setEquipmentItem($equipmentItem)
                    ->setCost($faker->numberBetween(1, 100))
                    ->setDateArrival($faker->dateTimeBetween('-3 week', 'now'))
                    ->setDateReturn($faker->dateTimeBetween('now', '+1 month'));
                $manager->persist($repair);
            }
        }

        $manager->flush();

        // Création des notifications
        foreach ($equipmentItems as $equipmentItem) {
            if ($equipmentItem->getState() === EquipmentState::HORS_SERVICE) {
                $notification = new Notification();
                $notification
                    ->setEquipmentItem($equipmentItem)
                    ->setType('HORS_SERVICE')
                    ->setMessage('L\'équipement est hors service')
                    ->setDate(new \DateTime($faker->date('Y-m-d', 'now')));
                $manager->persist($notification);
            } elseif ($equipmentItem->getState() === EquipmentState::EN_LOCATION) {
                // Récupérer le prêt associé à cet équipement
                $loan = $manager->getRepository(Loan::class)->findOneBy(['EquipmentItem' => $equipmentItem]);
                
                if ($loan) {
                    //Notification si la location est en retard
                    if ($loan->getDateDue() < new \DateTime()) {
                        $notification = new Notification();
                        $notification
                            ->setEquipmentItem($equipmentItem)
                            ->setType('RETARD')
                            ->setMessage('L\'équipement est en retard')
                            ->setDate($loan->getDateDue())
                            ->setUser($loan->getUser());
                        $manager->persist($notification);
                    }
                }
            }
        }

        //Création des mouvements (movement)
        foreach ($equipmentItems as $equipmentItem) {
            if ($equipmentItem->getState() === EquipmentState::EN_REPARATION) {
                $movement = new Movement();
                $repair = $manager->getRepository(Repair::class)->findOneBy(['EquipmentItem' => $equipmentItem]);
                $movement
                    ->setType('ENVOI_REPARATION')
                    ->setDate($repair->getDateArrival())
                    ->setRepair($repair);
                $manager->persist($movement);
            } elseif ($equipmentItem->getState() === EquipmentState::EN_LOCATION) {
                $movement = new Movement();
                $loan = $manager->getRepository(Loan::class)->findOneBy(['EquipmentItem' => $equipmentItem]);
                $movement
                    ->setType('ENVOI_LOCATION')
                    ->setDate($loan->getDateLoaned())
                    ->setLoan($loan);
                $manager->persist($movement);
            }
        }
        $manager->flush();
    }

    private function getWeightedRandomStatus(): EquipmentState
    {
        $random = mt_rand(1, 100);
        if ($random <= 70) {
            return EquipmentState::NEUF;
        } elseif ($random <= 65) {
            return EquipmentState::BON_ETAT;
        } elseif ($random <= 75) {
            return EquipmentState::USE;
        } elseif ($random <= 85) {
            return EquipmentState::EN_REPARATION;
        } elseif ($random <= 95) {
            return EquipmentState::EN_LOCATION;
        } else {
            return EquipmentState::HORS_SERVICE;
        }
    }

}
