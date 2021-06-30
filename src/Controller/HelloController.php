<?php


namespace App\Controller;

use App\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController extends AbstractController
{
    //Route et fonction pour tester des liens
    #[Route('/hello', name: 'hello')]
    public function hello(): Response
    {
        return new Response("Hello World ! : la route fonctionne bien");
    }
}