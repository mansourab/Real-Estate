<?php

namespace App\Controller\Account;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/account/index", name="account_index")
     */
    public function index(ItemRepository $repo) 
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $items = $repo->findAll();
        return $this->render('account/index.html.twig', [
            'items' => $items
        ]);
    }
}