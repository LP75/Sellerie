<?php

namespace App\Controller;

use App\Entity\EquipmentItem;
use App\Entity\Loan;
use App\Form\EquipmentItemType;
use App\Form\LoanType;
use App\Repository\CategoryRepository;
use App\Repository\EquipmentItemRepository;
use App\Repository\EquipmentTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipment')]
final class EquipmentItemController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route(name: 'app_equipment_item_index', methods: ['GET'])]
    public function index(EquipmentItemRepository $equipmentItemRepository, EquipmentTypeRepository $equipmentTypeRepository, CategoryRepository $categoryRepository): Response
    {
        $session = $this->requestStack->getSession();
        $userRole = $session->get('user_role', 'visitor');

        return $this->render('equipment_item/index.html.twig', [
            'equipment_items' => $equipmentItemRepository->findAll(),
            'user_role' => $userRole,
            'unique_brands' => $equipmentTypeRepository->findUniqueBrands(),
            'unique_categories' => $categoryRepository->findAllCategories(),
        ]);
    }

    #[Route('/new', name: 'app_equipment_item_new', methods: ['POST'])]
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

    // #[Route('/{id}', name: 'app_equipment_item_show', methods: ['POST'])]
    // public function show(EquipmentItem $equipmentItem): Response
    // {
    //     return $this->render('equipment_item/show.html.twig', [
    //         'equipment_item' => $equipmentItem,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_equipment_item_edit', methods: ['POST'])]
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
        if ($this->isCsrfTokenValid('delete'.$equipmentItem->getId(), $request->request->get('_token'))) {
            // Supprimer les prêts associés
            $loans = $equipmentItem->getLoans();
            foreach ($loans as $loan) {
                $entityManager->remove($loan);
            }
    
            $entityManager->remove($equipmentItem);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/loan', name: 'app_equipment_item_loan', methods: ['POST'])]
    public function loan(Request $request, EquipmentItem $equipmentItem, EntityManagerInterface $entityManager): Response
    {
        $loan = new Loan();
        $loan->setEquipmentItem($equipmentItem);
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isCsrfTokenValid('loan'.$equipmentItem->getId(), $request->request->get('_token'))) {
                $entityManager->persist($loan);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_equipment_item_index', [], Response::HTTP_SEE_OTHER);
            } else {
                throw $this->createAccessDeniedException('Invalid CSRF token.');
            }
        }
    
        return $this->render('equipment_item/loan.html.twig', [
            'equipment_item' => $equipmentItem,
            'form' => $form,
        ]);
    }
}
