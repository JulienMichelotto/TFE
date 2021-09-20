<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Curiculum;
use Knp\Snappy\Pdf;


class TestSnappyController extends AbstractController
{
    /**
     * @Route("/test/snappy", name="test_snappy")
     * @param Pdf $snappy
     * @param Request $request
     * @return Response
     */
    public function index(Pdf $snappy, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $currentCV = $em->getRepository(Curiculum::class)->find($request->get('id'));
        $dateForName = date("ymd-is");
        $nameFile = 'C:/wamp64/www/pdfmades/'.$dateForName.'-pdfname.pdf';
        $snappy->setOption('margin-bottom', '0mm');
		$snappy->setOption('margin-top', '0mm');
		$snappy->setOption('margin-left', '0mm');
        $snappy->setOption('margin-right', '0mm');
        $snappy->generateFromHtml(
            $this->renderView(
                'cv/cvTemplates/deluxeitalique.html.twig',
                array(
                    'curiculum'  => $currentCV,
                )
            ),
            $nameFile
        );
        $currentCV->setCvFile($nameFile);
        $em->persist($currentCV);
        $em->flush();
        return $this->render('cv/cvTemplates/deluxeitalique.html.twig', [
            'curiculum' => $currentCV,
        ]);
    }
}
