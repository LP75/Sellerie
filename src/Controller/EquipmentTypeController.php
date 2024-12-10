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
    // #[Route(name: 'app_equipment_type_index', methods: ['GET'])]
    // public function index(EquipmentTypeRepository $equipmentTypeRepository): Response
    // {
    //     return $this->render('equipment_type/index.html.twig', [
    //         'equipment_types' => $equipmentTypeRepository->findAll(),
    //     ]);
    // }

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

    // #[Route('/{id}', name: 'app_equipment_type_show', methods: ['GET'])]
    // public function show(EquipmentType $equipmentType): Response
    // {
    //     return $this->render('equipment_type/show.html.twig', [
    //         'equipment_type' => $equipmentType,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_equipment_type_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, EquipmentType $equipmentType, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(EquipmentTypeType::class, $equipmentType);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_equipment_type_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('equipment_type/edit.html.twig', [
    //         'equipment_type' => $equipmentType,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_equipment_type_delete', methods: ['POST'])]
    // public function delete(Request $request, EquipmentType $equipmentType, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$equipmentType->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($equipmentType);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_equipment_type_index', [], Response::HTTP_SEE_OTHER);
    // }
}
