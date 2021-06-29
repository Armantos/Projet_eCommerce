<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    //TODO ne fonctionne pas
    #[Route('/order/{id}', name: 'order')]
  //  #[Route('/order/{id}/{items}', name: 'order')]

    public function createOrder(int $id): Response
   // public function createOrder(int $id,Article $items): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $order = new Order();
        $user = $entityManager->getRepository(User::class)->find($id);

        $order->setBuyer($user);
        //$order->addPurchase($items);

        $entityManager->persist($order);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return $this->redirectToRoute('home');
    }
    #[Route('/billing', name: 'billing')]
    //  #[Route('/order/{id}/{items}', name: 'order')]

    public function createBilling(): Response
        // public function createOrder(int $id,Article $items): Response

    {

        return $this->render("/order/billing.html.twig");
    }
}

