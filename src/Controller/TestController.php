<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/Test', name: 'app_test')]
    public function index(): Response
    {
        
       $name= "BonjourHTML";
        return $this->render('Test/show.html.twig', [
            'namePage' => $name ,
        ]);
    }
}
