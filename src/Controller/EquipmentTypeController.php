<?php

namespace App\Controller;

use App\Entity\EquipmentType;
use App\Form\EquipmentTypeType;
use App\Repository\EquipmentTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipmentType')]
final class EquipmentTypeController extends AbstractController
{
    //Ajouter un nouveau type d'équipement
    #[Route('/new', name: 'app_equipment_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipmentType = new EquipmentType();
        $form = $this->createForm(EquipmentTypeType::class, $equipmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipmentType);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment_type/new.html.twig', [
            'equipment_type' => $equipmentType,
            'form' => $form,
        ]);
    }

}