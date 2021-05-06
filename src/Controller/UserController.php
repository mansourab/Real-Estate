<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserController extends AbstractController
{

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function update(User $user, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', "Vos informatios ont été modifié avec succès");

            return $this->redirectToRoute('account_index');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users", name="users_list")
     */
    public function list(UserRepository $userRepo, AuthorizationCheckerInterface $authChecker)
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            // throw new AccessDeniedException('Enable to access this page');
            
            $this->addFlash('danger', 'User tried to access a page without having ROLE_ADMIN');

            return $this->redirectToRoute('account_index');
        }

        $users = $userRepo->findAll();

        return $this->render('user/list.html.twig', compact('users'));

    }
}