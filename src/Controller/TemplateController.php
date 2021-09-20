<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\Template;
use App\Form\TemplateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{



    /**
     * @Route("/template", name="template")
     */
    public function index(): Response
    {
        return $this->render('template/index.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/templates", name="templateList")
     */
    public function templateList(): Response
    {
        $listTemplate = $this->getDoctrine()->getRepository(Template::class)->findAll();
        return $this->render('template/list.html.twig', [
            'listTemplate' => $listTemplate,
        ]);
    }

    /**
     * @Route("/template/create", name="templateCreate")
     */
    public function templateCreate(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $templateToAdd = new Template();
        $templateToAdd->setActive(true);
        if ($request->get('fond') == "true") {
            $templateToAdd->setDark(true);
        } else {
            $templateToAdd->setDark(false);
        }
        $templateToAdd->setDescr($request->get('modele'));
        $em->persist($templateToAdd);
        $em->flush();
        $listTemplate = $this->getDoctrine()->getRepository(Template::class)->findAll();
        return $this->render('template/listTemplate.html.twig', [
            'listTemplate' => $listTemplate,
        ]);
    }
    /**
     * @Route("/template/delete", name="templateDelete")
     */
    public function templateDelete(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $templateToDell = $this->getDoctrine()->getRepository(Template::class)->find($request->get('idTemplate'));
        $templateToDell->setActive(false);
        $em->persist($templateToDell);
        $em->flush();
        $listTemplate = $this->getDoctrine()->getRepository(Template::class)->findAll();
        return $this->render('template/listTemplate.html.twig', [
            'listTemplate' => $listTemplate,
        ]);
    }
    /**
     * @Route("template/edite", name="templateEdite")
     */
    public function templateEdite(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Template $templateToShow  */
        $templateToShow = $this->getDoctrine()->getRepository(Template::class)->find($request->get('id'));
        /** Initialier les couleurs à null pour ne pas les ajouter en double ou bien ne rien ajouter si il n'y en a aucune */
        $arrayOfColor = $templateToShow->getColors();
        foreach ($arrayOfColor as $color) {
            $templateToShow->removeColor($color);
        }
        $templateToShow->setDescr($request->get('modeleToSend'));
        
        if ($request->get('fondToSend') == "true") {
            $templateToShow->setDark(true);
        } else {
            $templateToShow->setDark(false);
        }
        if ($request->get('arrayColorToSend')) {
            if (sizeof($request->get('arrayColorToSend'))>0) {
                foreach ($request->get('arrayColorToSend') as $color) {
                    $templateToShow->addColor($this->getDoctrine()->getRepository(Color::class)->findOneBy(['id' => $color]));
                }
             }
        }
        $em->persist($templateToShow);
        $em->flush();
        return new Response('OK', 200);
    }

    /**
     * @Route("/template/{id}", name="templateShow")
     * @param Request $request
     */
    public function templateShow(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $templateToShow = $this->getDoctrine()->getRepository(Template::class)->find($request->attributes->get('id'));
        $listColor = $this->getDoctrine()->getRepository(Color::class)->findAll();
        return $this->render('template/editeTemplate.html.twig', [
            'templateToShow' => $templateToShow,
            'colorList' => $listColor,
        ]);
    }

}
