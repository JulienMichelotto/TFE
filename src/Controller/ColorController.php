<?php

namespace App\Controller;

use App\Entity\Color;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColorController extends AbstractController
{
    /**
     * @Route("/color", name="color")
     */
    public function index(): Response
    {
        return $this->render('color/index.html.twig', [
            'controller_name' => 'ColorController',
        ]);
    }
    
    /**
     * @Route("/colors", name="listColor")
     */
    public function listColor(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $listColor = $em->getRepository(Color::class)->findAll();
        return $this->render('color/list.html.twig', [
            'listColor' => $listColor,
        ]);
    }
    
    /**
     * @Route("/color/create", name="colorCreate")
     */
    public function colorCreate(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $colorToCreate = new Color();
        $colorToCreate->setDescr($request->get('color'));
        $colorToCreate->setActive(true);
        $em->persist($colorToCreate);
        $em->flush();
        $listColor = $em->getRepository(Color::class)->findAll();
        return $this->render('color/listColor.html.twig', [
            'listColor' => $listColor,
        ]);
    }
    
    /**
     * @Route("/color/delete", name="colorDelete")
     */
    public function colorDelete(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $colorToDelete = $em->getRepository(Color::class)->find($request->get('idColor'));
        $colorToDelete->setActive(false);
        $em->persist($colorToDelete);
        $em->flush();
        $listColor = $em->getRepository(Color::class)->findAll();
        return $this->render('color/listColor.html.twig', [
            'listColor' => $listColor,
        ]);
    }
}
