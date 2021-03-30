<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Item;
use App\Form\ItemFormType;
use App\Form\SearchForm;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class ItemController extends AbstractController
{

    private $em;

    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/items", name="item_index")
     */
    public function index(ItemRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {

        $data = new SearchData();

        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $items = $repo->findSearch($data);

        return $this->render('item/index.html.twig', [
            'items' => $items,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/create", name="item_add")
     */
    public function add(Request $request)
    {
        $item = new Item();

        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', 'Item successfully added');

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/edit/{id}", name="item_edit")
     */
    public function edit(Item $item, Request $request)
    {
        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/{id}", name="item_show")
     */
    public function show(Item $item)
    {
        return $this->render('item/show.html.twig', [
            'item' => $item
        ]);
    }


}
