<?php

namespace App\Controller;

use App\Entity\EquipmentItem;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\EquipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipmentTypes = $entityManager->getRepository(EquipmentType::class)->findAll();

        return $this->render('home/index.html.twig', [
            'equipmentTypes' => $equipmentTypes,
        ]);
    }
}
