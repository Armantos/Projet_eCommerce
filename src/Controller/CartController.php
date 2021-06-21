<?php

namespace App\Controller;

use App\Entity\Article;

use App\Repository\ArticleRepository;
use Cart;
use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Stripe\Stripe;


class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository) : Response
    {
        
        $cart = $session->get('cart', []);

        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'article' => $articleRepository->find($id),
                'quantity' => $quantity,
            ];
        }

        $total = 0;
        foreach ($cartWithData as $item) {
            $totalItem = $item['article']->getPrice() * $item['quantity'];

            $total += $totalItem;
        }

        return $this->render('cart/cart.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'addCart')]
    public function addCart($id, SessionInterface $session) : Response
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute("cart");
    }

    #[Route('/cart/remove/{id}', name: 'removeCart')]
    public function removeCart($id, SessionInterface $session) : Response
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute(("cart"));
    }

    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        
        \Stripe\Stripe::setApiKey('sk_test_51J4SPfIocXlW1GMrf5DAoN0i67BaiqnUpEzzBlb5t93a01xUdfqHRU9FGS74Gq1baPp7d5rrywNVtjl3lK9ojJQ500IKG8dBuJ');
       
        $session = \Stripe\Checkout\Session::create([
            
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Tshirt',
                    ],
                    'unit_amount' =>'40000' 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse(['id' => $session->id]);
    }
    

    #[Route('/error', name: 'error')]
    public function error()
    {
        return $this->render("/cart/error.html.twig");
    }


    #[Route('/success', name: 'success')]
    public function success()
    {
        return $this->render("/cart/success.html.twig");
    }

}