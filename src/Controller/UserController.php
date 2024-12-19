<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    private $requestStack;
    private $security;
    private $notificationRepository;

    public function __construct(RequestStack $requestStack, Security $security, NotificationRepository $notificationRepository)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->notificationRepository = $notificationRepository;
    }

    //Liste des utilisateurs
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $session = $this->requestStack->getSession();
        $userRole = $session->get('user_role', 'visitor');
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'user_role' => $userRole,
        ]);
    }

    //Supprimer un utilisateur
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            $notifications = $user->getNotifications();
            foreach ($notifications as $notification) {
                $entityManager->remove($notification);
            }

            $loans = $user->getLoans();
            foreach ($loans as $loan) {
                $movements = $loan->getMovements();
                foreach ($movements as $movement) {
                    $entityManager->remove($movement);
                }
                $entityManager->remove($loan);
            }

            $entityManager->remove($user);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
