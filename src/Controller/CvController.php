<?php

namespace App\Controller;

use App\Entity\Curiculum;
use App\Entity\Extra;
use App\Entity\ExtraDetail;
use App\Entity\Formation;
use App\Entity\FormationDetail;
use App\Entity\Job;
use App\Entity\JobDetail;
use App\Entity\User;
use App\Form\CuriculumType;
use App\Form\CurriculumEditeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CvController extends AbstractController
{
    /**
     * @Route("/curiculum/download/{id}", name="dlCuriculum")
     * @param $id
     * @param Request $request
     */
    public function dlCuriculum(Security $security, Request $request, $id): Response
    {
        $fileToDl = $this->getDoctrine()->getRepository(Curiculum::class)->find($id)->getCvFile();
        $response = new BinaryFileResponse($fileToDl);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }
    /**
     * @Route("/cv", name="cv")
     */
    public function index(): Response
    {
        return $this->render('cv/index.html.twig', [
            'controller_name' => 'CvController',
        ]);
    }
    /**
     * @Route("/cvDynamique", name="cvDynamique")
     */
    public function cvDynamique(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $currentCV = $em->getRepository(Curiculum::class)->find(1);
        return $this->render('cv/cvTemplates/deluxeitalique.html.twig', [
            'curiculum' => $currentCV,
        ]);
    }
    /**
     * @Route("/curiculums/admin", name="curiculumListAdmin")
     * @param Request $request
     */
    public function cvListAdmin(Security $security, Request $request): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $em = $this->getDoctrine()->getManager();
            $curiculumToAdd = new Curiculum();
            $form = $this->createForm(CuriculumType::class, $curiculumToAdd);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $curiculumToAdd->setUser($user);
                $curiculumToAdd->setActive(true);
                $em->persist($curiculumToAdd);
                $em->flush();
            }
            $cvList = $em->getRepository(Curiculum::class)->findAll();

            return $this->render('cv/list.html.twig', [
                'form' => $form->createView(),
                'cvList' => $cvList,
                'currentUser' => $user,
            ]);
        } else {
            return $this->redirectToRoute('curiculumList');
        }
    }
    /**
     * @Route("/curiculums/", name="curiculumList")
     * @param Request $request
     */
    public function curiculumList(Security $security, Request $request): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $em = $this->getDoctrine()->getManager();
        $curiculumToAdd = new Curiculum();
        $form = $this->createForm(CuriculumType::class, $curiculumToAdd);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $curiculumToAdd->setUser($user);
            $curiculumToAdd->setActive(true);
            $em->persist($curiculumToAdd);
            $em->flush();
        }
        $cvList = $user->getCv();
        return $this->render('cv/list.html.twig', [
            'form' => $form->createView(),
            'cvList' => $cvList,
            'currentUser' => $user,
        ]);
    }

    /**
     * @Route("/curiculum/create", name="curiculumCreate")
     */
    public function cvCreate(Security $security, Request $request): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $em = $this->getDoctrine()->getManager();
        $cvToCreate = new Curiculum();
        $cvToCreate->setTitle($request->get('title'));
        $cvToCreate->setActive(true);
        $cvToCreate->setUser($user);
        $em->persist($cvToCreate);
        $em->flush();
        $cvList = $user->getCv();
        return $this->redirectToRoute('curiculumList', [
            'cvList' => $cvList,
            'curiculum' => $cvToCreate,
        ]);
    }
    /**
     * @Route("/curiculum/delete/", name="curiculumDelete")
     * @param Request $request
     */
    public function cvDelete(Security $security, Request $request): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        $em = $this->getDoctrine()->getManager();
        $cvToDelete = $em->getRepository(Curiculum::class)->find($request->get('idCv'));
        $cvToDelete->setActive(false);
        $em->persist($cvToDelete);
        $em->flush();
        $cvList = $user->getCv();
        return $this->render('cv/listeCv.html.twig', [
            'cvList' => $cvList,
        ]);
    }
    /**
     * @Route("/curiculum/{id}", name="curiculumShow")
     * @param Request $request
     */
    public function cvShow(Security $security, Request $request): Response
    {
        /**
         * @TODO il faut rediriger l'utilisateur si il tente de modifier un ciriculum qui ne lui appartien pas vers 
         * une page qui lui informe que ce CV ne lui appartient pas
         */

        /** @var User $user */
        $user = $security->getUser();
        dump($request);
        $em = $this->getDoctrine()->getManager();
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->attributes->get('id'));
        $form = $this->createForm(CurriculumEditeType::class,$cvToEdit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($cvToEdit);
            $em->flush();
        }
        return $this->render('cv/cvEdit.html.twig', [
            "curiculum" => $cvToEdit,
            "currentUser" => $user,
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/job/create", name="createJob")
     * @param Request $request
     */
    public function createJob(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('id'));
        /** @var Job $jobToAdd */
        $jobToAdd = new Job();
        $jobToAdd->setCuriculum($cvToEdit);
        $jobToAdd->setDescr($request->get('descr'));
        $jobToAdd->setJobCity($request->get('jobCity'));
        $jobToAdd->setActive(true);
        if ($request->get('societyName') != '') {
            $jobToAdd->setSocietyName($request->get('societyName'));
        }
        $jobToAdd->setStart(date_create($request->get('start')));
        if ($request->get('end') != '') {
            $jobToAdd->setEnd(date_create($request->get('end')));
        }
        $em->persist($jobToAdd);
        $em->flush();
        return $this->render('cv/listJob.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/job/detail/create", name="createDetailJob")
     * @param Request $request
     */
    public function createDetailJob(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Job $jobToEdite */
        $jobToEdite = $em->getRepository(Job::class)->find($request->get('idJob'));
        $jobDetailToAdd = new JobDetail();
        $jobDetailToAdd->setJob($jobToEdite);
        $jobDetailToAdd->setDetail($request->get('detail'));
        $em->persist($jobDetailToAdd);
        $em->flush();
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get(('idCuriculum')));
        return $this->render('cv/listJob.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }

    /**
     * @Route("/job/delete", name="deleteJob")
     * @param Request $request
     */
    public function deleteJob(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        /** @var Job $jobToDelete */
        $jobToDelete = $em->getRepository(Job::class)->find($request->get('idJob'));
        $jobToDelete->setActive(false);
        $em->persist($jobToDelete);
        $em->flush();
        return $this->render('cv/listJob.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }

    /**
     * @Route("/job/detail/delete", name="deleteDetailJob")
     * @param Request $request
     */
    public function deleteDetailJob(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        /** @var JobDetail $jobDetailToDelete */
        $jobDetailToDelete = $em->getRepository(JobDetail::class)->find($request->get('idJobDetail'));
        $em->remove($jobDetailToDelete);
        $em->flush();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        return $this->render('cv/listJob.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }

    /**
     * @Route("/formation/create", name="createFormation")
     * @param Request $request
     */
    public function createFormation(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('id'));
        /** @var Formation $formToAdd */
        $formToAdd = new Formation();
        $formToAdd->setCuriculum($cvToEdit);
        $formToAdd->setDescr($request->get('descr'));
        $formToAdd->setCity($request->get('city'));
        $formToAdd->setActive(true);
        if ($request->get('societyName') != '') {
            $formToAdd->setName($request->get('societyName'));
        }
        $formToAdd->setStart(date_create($request->get('start')));
        if ($request->get('end') != '') {
            $formToAdd->setEnd(date_create($request->get('end')));
        }
        $em->persist($formToAdd);
        $em->flush();
        return $this->render('cv/listForm.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/formation/delete", name="deleteFormation")
     * @param Request $request
     */
    public function deleteFormation(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        /** @var Formation $formToDelete */
        $formToDelete = $em->getRepository(Formation::class)->find($request->get('idForm'));
        $formToDelete->setActive(false);
        $em->persist($formToDelete);
        $em->flush();
        return $this->render('cv/listForm.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/formation/detail/create", name="createFormationDetail")
     * @param Request $request
     */
    public function createFormationDetail(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Formation $formToEdite */
        $formToEdite = $em->getRepository(Formation::class)->find($request->get('idForm'));
        $formDetailToAdd = new FormationDetail();
        $formDetailToAdd->setFormation($formToEdite);
        $formDetailToAdd->setDetail($request->get('detail'));
        $em->persist($formDetailToAdd);
        $em->flush();
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get(('idCuriculum')));
        return $this->render('cv/listForm.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/formation/detail/delete", name="deleteDetailFormation")
     * @param Request $request
     */
    public function deleteDetailFormation(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        /** @var FormationDetail $formDetailToDelete */
        $formDetailToDelete = $em->getRepository(FormationDetail::class)->find($request->get('idFormDetail'));
        $em->remove($formDetailToDelete);
        $em->flush();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        return $this->render('cv/listForm.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }

    /***************************************** */
    /**
     * @Route("/extra/create", name="createExtra")
     * @param Request $request
     */
    public function createExtra(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('id'));
        /** @var Extra $extraToAdd */
        $extraToAdd = new Extra();
        $extraToAdd->setCuriculum($cvToEdit);
        $extraToAdd->setTitle($request->get('title'));
        $extraToAdd->setActive(true);
        $em->persist($extraToAdd);
        $em->flush();
        return $this->render('cv/listExtra.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/extra/delete", name="deleteExtra")
     * @param Request $request
     */
    public function deleteExtra(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        /** @var Extra $extraToDelete */
        $extraToDelete = $em->getRepository(Extra::class)->find($request->get('idExtra'));
        $extraToDelete->setActive(false);
        $em->persist($extraToDelete);
        $em->flush();
        return $this->render('cv/listExtra.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/extra/detail/create", name="createExtraDetail")
     * @param Request $request
     */
    public function createExtraDetail(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Extra $extraToEdite */
        $extraToEdite = $em->getRepository(Extra::class)->find($request->get('idExtra'));
        $extraDetailToAdd = new ExtraDetail();
        $extraDetailToAdd->setExtra($extraToEdite);
        $extraDetailToAdd->setDetail($request->get('detail'));
        $em->persist($extraDetailToAdd);
        $em->flush();
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get(('idCuriculum')));
        return $this->render('cv/listExtra.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
    /**
     * @Route("/extra/detail/delete", name="deleteDetailExtra")
     * @param Request $request
     */
    public function deleteDetailExtra(Security $security, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ExtraDetail $extraDetailToDelete */
        $extraDetailToDelete = $em->getRepository(ExtraDetail::class)->find($request->get('idExtraDetail'));
        $em->remove($extraDetailToDelete);
        $em->flush();
        /** @var Curiculum $cvToEdit */
        $cvToEdit = $em->getRepository(Curiculum::class)->find($request->get('idCuriculum'));
        return $this->render('cv/listExtra.html.twig', [
            "curiculum" => $cvToEdit,
        ]);
    }
}
