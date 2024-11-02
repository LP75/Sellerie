<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        $session = $this->requestStack->getSession();
        $role = $session->get('user_role', 'visitor');

        return $this->render('menu.html.twig', [
            'user_role' => $role,
        ]);
    }
}