<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class HomeController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    //Page d'accueil
    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $session = $this->requestStack->getSession();

        if ($this->isGranted('ROLE_ADMIN')) {
            $session->set('user_role', 'admin');
            return $this->redirectToRoute('app_equipment_item_index');
        }

        if ($this->isGranted('ROLE_USER')) {
            $session->set('user_role', 'user');
            return $this->redirectToRoute('app_equipment_item_index');
        }

        $session->set('user_role', 'visitor');
        return $this->redirectToRoute('app_equipment_item_index');
    }
}