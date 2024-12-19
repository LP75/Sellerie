<?php

namespace App\Controller;

use App\Repository\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RepairController extends AbstractController
{   
    //Liste des réparations
    #[Route('/repair', name: 'app_repair')]
    public function index(RepairRepository $repairRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('repair/index.html.twig', [
            'repairs' => $repairRepository->findAll(),
        ]);
    }
}
