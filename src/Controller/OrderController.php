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
    //  #[Route('/order', name: 'order')]
    #[Route('/order/{id}/{items}', name: 'order')]

    public function createOrder($id, $items): Response
   // public function createOrder(int $id,Article $items): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $order = new Order();

       // $user = $entityManager->getRepository(User::class)->find($id);

        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoArticle = $this->getDoctrine()->getRepository(Article::class);

        $user = $repoUser->find($id);
       // $article = $repoArticle->find($items);

        $order->setUser($user);
        $order->setListArticle($items);

        $entityManager->persist($order);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return $this->redirectToRoute('home');
    }
}