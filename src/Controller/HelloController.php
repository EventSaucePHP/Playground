<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'hello')]
    public function helloAction(): Response
    {
        return $this->render('hello.html.twig', ['title' => 'Hello!']);
    }
}
