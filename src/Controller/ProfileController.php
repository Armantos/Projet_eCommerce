<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
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

        //TODO verifier si les champs ne sont pas vides
        //TODO verifier si le username n'existe pas deja
        $user->setUsername('New user name!');
        $user->setFirstName('New first name!');
        $user->setLastName('New last name!');

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
        $repo = $this->getDoctrine()->getRepository(Order::class);

        $orders = $repo->findAll();

        //dd($articles); //debug pour afficher le tableau d'articles

        return $this->render("/profile/orders.html.twig",
            ['orders' => $orders,
            ]);
    }
}
