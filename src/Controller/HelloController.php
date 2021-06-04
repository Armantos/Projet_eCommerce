<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController
{

    /**
     * @Route("/hello")
     */
    public function hello() : Response
    {
      return new Response("helloworld!");
    }
}