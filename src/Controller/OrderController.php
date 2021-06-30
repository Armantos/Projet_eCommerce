<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

class OrderController extends AbstractController
{

    #[Route('/order/{id}', name: 'order')]
        public function createOrder(SessionInterface $session, ArticleRepository $articleRepository, UserRepository $userRepository, $id): Response
    {
        //creation de la commande
        $order = new Order();

        $entityManager = $this->getDoctrine()->getManager();

        //Attribution de l'id de l'acheteur
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->find($id);
        $order->setUser($user);

        $entityManager->persist($order);

        //Recuperation du panier dans la session
        $cart = $session->get('cart', []);

        //Pour chaque article dans le panier, on creer un orderItem
        foreach ($cart as $idArticle => $quantity) {
            $orderItem = new OrderItem();
            $orderItem->setArticle($articleRepository->find($idArticle));
            $orderItem->setQuantity($quantity);
            $orderItem->setOrderDone($order);
            $entityManager->persist($orderItem);

            //Ajout de l'orderItem dans la commande
            $order->addOrderItem($orderItem);
        }

        $entityManager->persist($order);
        $entityManager->flush();

        $session->remove('cart');

        return $this->redirectToRoute('home');
    }
    #[Route('/billing', name: 'billing')]
    //  #[Route('/order/{id}/{items}', name: 'order')]

    public function createBilling(): Response
        // public function createOrder(int $id,Article $items): Response

    {

        return $this->render("/order/billing.html.twig");
    }


    #[Route('/stats', name: 'stats')]
    public function Stats(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        //dd($articles); //debug pour afficher le tableau d'articles

        return $this->render("/order/stats.html.twig",
            ['articles' => $articles,
            ]);
    }
}

