<?php

namespace App\Controller;

use App\Entity\EquipmentItem;
use App\Form\EquipmentItemType;
use App\Repository\EquipmentItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipment')]
final class EquipmentItemController extends AbstractController
{
    #[Route(name: 'app_equipment_item_index', methods: ['GET'])]
    public function index(EquipmentItemRepository $equipmentItemRepository): Response
    {
        return $this->render('equipment_item/index.html.twig', [
            'equipment_items' => $equipmentItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipment_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipmentItem = new EquipmentItem();
        $form = $this->createForm(EquipmentItemType::class, $equipmentItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipmentItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment_item/new.html.twig', [
            'equipment_item' => $equipmentItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipment_item_show', methods: ['GET'])]
    public function show(EquipmentItem $equipmentItem): Response
    {
        return $this->render('equipment_item/show.html.twig', [
            'equipment_item' => $equipmentItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipment_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipmentItem $equipmentItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipmentItemType::class, $equipmentItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment_item/edit.html.twig', [
            'equipment_item' => $equipmentItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipment_item_delete', methods: ['POST'])]
    public function delete(Request $request, EquipmentItem $equipmentItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipmentItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipmentItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
