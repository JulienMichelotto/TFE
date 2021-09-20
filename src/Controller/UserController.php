<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserModificationType;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="userList")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $userArray = $em->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'userArray' => $userArray,
        ]);
    }

    /**
     * @Route("/edit/user/{id}", name="editUser")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editUser(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($request->attributes->get('id'));

        $form = $this->createForm(UserModificationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->render('user/edit.html.twig', [
                'form' => $form->createView(),
                'userSelected' => $user
            ]);
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'userSelected' => $user
        ]);
    }
}
