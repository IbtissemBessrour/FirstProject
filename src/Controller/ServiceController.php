<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/service/{name}', name: 'Showservice')]
    public function showService($name):Response
    {
        return $this->render('service/show.html.twig',['n'=>$name]);
    }

    #[Route('/goToIndex', name: 'goToIndexservice')]
    public function goToIndex(): Response 
    {
        return $this->redirectToRoute('app_home');
    }
}
