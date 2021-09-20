<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="goHome")
     */
    public function goHome(): Response
    {
        if ( $this->getUser())  return $this->redirectToRoute('curiculumList');
        else{
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
        }
    }
    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
