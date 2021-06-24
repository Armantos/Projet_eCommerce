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


class CheckoutController extends AbstractController
{
    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        //cle Nabil
        //  \Stripe\Stripe::setApiKey('sk_test_51J4SPfIocXlW1GMrf5DAoN0i67BaiqnUpEzzBlb5t93a01xUdfqHRU9FGS74Gq1baPp7d5rrywNVtjl3lK9ojJQ500IKG8dBuJ');

        //cle Armand
        \Stripe\Stripe::setApiKey('sk_test_51J5GMPL4f65gcecvV7Y7KNgbqyqfNX6ASG0E458iWMYlcQgF9VYoMmGAC9Km4wCsaVATcuTwu6TgTlxfjeT4fHse00eqcPvHrw');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Total à régler',
                    ],
                    'unit_amount' => 420,
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