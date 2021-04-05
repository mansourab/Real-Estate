<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    /**
     * @Route("/users", name="users_list")
     */
    public function list(UserRepository $userRepo)
    {
        $users = $userRepo->findAll();

        return $this->render("user/list.html.twig", [
            'users' => $users
        ]);
    }
}