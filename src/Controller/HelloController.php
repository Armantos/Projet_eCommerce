<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController
{


    #[Route('/hello', name: 'hello')]
    public function hello() : Response
    {
      return new Response("Hello World ! : la route fonctionne bien");
    }
}