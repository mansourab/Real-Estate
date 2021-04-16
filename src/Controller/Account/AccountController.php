<?php

namespace App\Controller\Account;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AccountController extends AbstractController
{

    /**
     * @Route("/account/index", name="account_index")
     */
    public function index(ItemRepository $repo, Request $request) 
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data = new SearchData();

        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $items = $repo->findSearch($data);

        return $this->render('account/index.html.twig', [
            'items' => $items,
            'form' => $form->createView()
        ]);
    }
}