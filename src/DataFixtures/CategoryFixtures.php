<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
