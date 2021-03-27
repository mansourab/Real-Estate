<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemFormType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ItemController extends AbstractController
{
    /**
     * @Route("/items", name="item_index")
     */
    public function index(ItemRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {

        $items = $paginator->paginate(
            $repo->findAll(), /* query NOT result */
            $request->query->getInt('page', 1),
            6 
        );

        return $this->render('item/index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/item/create", name="item_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $item = new Item();

        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($item);
            $em->flush();
        }

        return $this->render('item/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/item/edit/{id}", name="item_edit")
     */
    public function edit(Item $item, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
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
