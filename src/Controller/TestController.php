<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{
    #[Route('/test/')]
    public function test()
    {
        return $this->render('test.html.twig', [

        ]);
    }
}
