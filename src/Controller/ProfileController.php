<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'profile')]
    public function showProfile(): Response
    {
        return $this->render("/profile/profile.html.twig");
    }

    //TODO edit user
    #[Route('/profile/edit/{id}', name: 'editUser')]
    public function updateProfile(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setUsername('New user name!');
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

        $session = new Session();
        $session->invalidate();

        return $this->redirectToRoute('home');


    }
}
