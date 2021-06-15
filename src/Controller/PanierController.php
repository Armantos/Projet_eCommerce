<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/NABIL', name: 'NABIL')]
    public function index(): Response
    {
        return $this->render('cart/cart.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
}
