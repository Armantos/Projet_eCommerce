<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'profile')]
    public function showProfile(): Response
    {
        return $this->render("/profile/profile.html.twig");
    }

    //TODO edit user
    #[Route('/profile/edit/{id}', name: 'editUser')]
    public function updateProfile(int $id, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        //TODO ajouter le formulaire de modification des infos
        $user->setUsername('new username');
        $user->setFirstName('new firstname');
        $user->setLastName('new lastname');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'test12'
                //$form->get('plainPassword')->getData()
            )
        );
        $entityManager->flush();

        return $this->redirectToRoute('profile');
    }

    #[Route('/profile/delete/{id}', name: 'deleteUser')]
    public function deleteProfile(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        //Supprime la session
        $session = new Session();
        $session->invalidate();

        return $this->redirectToRoute('home');
    }

    #[Route('/profile/showOrders/{id}', name: 'showOrders')]
    public function showOrders(int $id): Response
    {
        $repoOrder = $this->getDoctrine()->getRepository(Order::class);
        $orders = $repoOrder->findAll();

        $repoOrderItem = $this->getDoctrine()->getRepository(OrderItem::class);
        $orderItems = $repoOrderItem->findAll();

        $repoArticle = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repoArticle->findAll();

        return $this->render("/profile/orders.html.twig",
            ['orders' => $orders,
             'orderItems' => $orderItems,
             'articles' => $articles,
            ]);
    }
}
